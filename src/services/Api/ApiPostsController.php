<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/UtilityService.php';

class ApiPostsController
{
    private DatabaseConnector $databaseConnector;
    private ApiAuthController $authController;
    private UtilityService $utilityService;

    public array $categories = [
        ["id" => "drones", "name" => "Drony"],
        ["id" => "accessories", "name" => "Příslušenství"],
        ["id" => "media", "name" => "Fotografie, videa a jiná média"],
        ["id" => "software", "name" => "Software pro drony"],
        ["id" => "other", "name" => "Ostatní"],
    ];

    public function __construct()
    {
        $this->databaseConnector = new DatabaseConnector();
        $this->authController = new ApiAuthController();
        $this->utilityService = new UtilityService();
    }

    /**
     * Creates a new post
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function create(array $data): void
    {
        try {
            // check if all required fields are filled
            if (empty($data["slug"]) ||
                empty($data["title"]) ||
                empty($data["short_summary"]) ||
                empty($data["content"]) ||
                empty($data["category"])
            ) {
                throw new Exception("Nevyplnil/a jste všechny potřebné informace.");
            }

            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro vytvoření příspěvku se musíte přihlásit.");
            }

            // create slug that also serves as unique identifier for the post
            $slug = trim($data["slug"]);
            while (!$this->isSlugAvailable($slug)) {
                $slug = $this->databaseConnector->escape(
                    $this->utilityService->normalizeString($data["slug"] . "-" . rand(1000, 999999))
                );
            }

            // save to db
            $result = [
                "slug" => $this->databaseConnector->escape($slug),
                "title" => $this->databaseConnector->escape(
                    $this->utilityService->normalizeString($data["title"])
                ),
                "short_summary" => $this->databaseConnector->escape(
                    $this->utilityService->normalizeString($data["short_summary"])
                ),
                "author" => $currentUser["uuid"],
                "content" => $data["content"],
                "category" => $this->databaseConnector->escape($data["category"]),
                "date_created" => date("Y-m-d H:i:s"),
                "date_updated" => date("Y-m-d H:i:s"),
                "status" => "ACTIVE",
            ];

            $this->databaseConnector->insert(
                table: "posts",
                data: $result
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage());
            exit();
        }
    }

    /**
     * Edits a post
     * @param string $postSlug
     * @param array $newData
     * @return void
     * @throws Exception
     */
    public function edit(string $postSlug, array $newData): void
    {
        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro editaci příspěvku se musíte přihlásit.");
            }

            $result = [
                "title" => $this->databaseConnector->escape($newData["title"]),
                "short_summary" => $this->databaseConnector->escape($newData["short_summary"] ?? ""),
                "content" => $newData["content"],
                "date_updated" => date("Y-m-d H:i:s"),
            ];

            // check if the post exists and is owned by the user
            $savedPost = $this->getPostBySlug($postSlug);
            if (empty($savedPost) || $savedPost["author"] != $currentUser["uuid"]) {
                throw new Exception("Příspěvek neexistuje nebo není váš.");
            }

            // update post
            $this->databaseConnector->update(
                table: "posts",
                data: $result,
                conditionColumn: "slug",
                conditionValue: $postSlug,
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage());
            exit();
        }
    }

    /**
     * Deletes a post and all its comments
     * @param string $postSlug
     * @return void
     * @throws Exception
     */
    public function delete(string $postSlug): void
    {
        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro smazání příspěvku se musíte přihlásit.");
            }

            $savedPost = $this->getPostBySlug($postSlug);
            if (empty($savedPost) || $savedPost["author"] != $currentUser["uuid"]) {
                throw new Exception("Příspěvek neexistuje nebo není váš.");
            }

            // delete post
            $this->databaseConnector->delete(
                table: "posts",
                conditionColumn: "slug",
                conditionValue: $postSlug,
            );

            // delete comments
            $this->databaseConnector->delete(
                table: "posts_comments",
                conditionColumn: "post_id",
                conditionValue: $savedPost["id"]
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Retrieves a post by its slug
     * @param string $slug
     * @return array
     * @throws Exception
     */
    public function getPostBySlug(string $slug): array
    {
        return $this->databaseConnector->selectOneRow(
            "
            SELECT * FROM posts
            WHERE slug = '" . $this->databaseConnector->escape($slug) . "'"
        ) ?? [];
    }

    /**
     * Checks if a given slug is available
     * @param string $slug
     * @return bool
     * @throws Exception
     */
    private function isSlugAvailable(string $slug): bool
    {
        return empty($this->getPostBySlug($slug));
    }
}