<?php

class ApiPostsController
{
    private DatabaseConnector $databaseConnector;
    private ApiAuthController $authController;
    private UtilityService $utilityService;

    public function __construct()
    {
        require_once 'src/services/DatabaseConnector.php';
        require_once 'src/services/Api/ApiAuthController.php';
        require_once 'src/services/UtilityService.php';

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
        // check if all required fields are filled
        if (empty($data["slug"]) ||
            empty($data["title"]) ||
            empty($data["short_summary"]) ||
            empty($data["content"]) ||
            empty($data["category"])
        ) {
            throw new Exception("Nevyplnil/a jste všechny potřebné informace");
        }

        $currentUser = $this->authController->getCurrentUser() ?? [];
        if (empty($currentUser)) {
            throw new Exception("Pro vytvoření příspěvku se musíte přihlásit.");
        }

        // create slug that also serves as unique identifier for the post
        $slug = trim($data["slug"]);
        while(!$this->isSlugAvailable($slug)) {
            $slug = $this->utilityService->normalizeString($data["slug"] . "-" . rand(1000, 999999));
        }

        // save to db
        $result = [
            "slug" => $slug,
            "title" => $this->utilityService->normalizeString($data["title"]),
            "short_summary" => $this->utilityService->normalizeString($data["short_summary"]),
            "author" => $currentUser["uuid"],
            "content" => $data["content"],
            "category" => $data["category"],
            "date_created" => date("Y-m-d H:i:s"),
            "date_updated" => date("Y-m-d H:i:s"),
            "status" => "ACTIVE",
        ];

        try {
            $this->databaseConnector->insert("posts", $result);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // now the post is saved, retrieve if for attachments
        $savedPost = $this->getPostBySlug($slug);

        $attachments = $data["attachments"] ?? [];
        if (!empty($attachments)) {
            $this->insertOrUpdateAttachments($attachments, $savedPost["id"]);
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
        $currentUser = $this->authController->getCurrentUser() ?? [];
        if (empty($currentUser)) {
            throw new Exception("Pro editaci příspěvku se musíte přihlásit.");
        }

        $result = [
            "slug" => $postSlug,
            "short_summary" => $newData["short_summary"] ?? "",
            "content" => $newData["content"],
            "date_updated" => date("Y-m-d H:i:s"),
        ];

        // check if the post exists and is owned by the user
        $savedPost = $this->getPostBySlug($postSlug);
        if (empty($savedPost) || $savedPost["author"] != $currentUser["uuid"]) {
            throw new Exception("Příspěvek neexistuje nebo není váš.");
        }

        try {
            // update post
            $this->databaseConnector->update(
                "posts", $result,
                "slug",
                $postSlug
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // attachments
        $attachments = $newData["attachments"] ?? [];
        if (!empty($attachments)) {
            $this->insertOrUpdateAttachments($attachments, $savedPost["id"]);
        }
    }

    /**
     * Deletes a post and all its attachments and comments
     * @param string $postSlug
     * @return void
     * @throws Exception
     */
    public function delete(string $postSlug): void
    {
        $currentUser = $this->authController->getCurrentUser() ?? [];
        if (empty($currentUser)) {
            throw new Exception("Pro smazání příspěvku se musíte přihlásit.");
        }

        $savedPost = $this->getPostBySlug($postSlug);
        if (empty($savedPost) || $savedPost["author"] != $currentUser["uuid"]) {
            throw new Exception("Příspěvek neexistuje nebo není váš.");
        }

        // delete post
        try {
            $this->databaseConnector->delete(
                "posts",
                "slug",
                $postSlug
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // delete attachments
        try {
            $this->databaseConnector->delete(
                "posts_attachments",
                "post_id",
                $savedPost["id"]
            );
        } catch (Exception $e) {
            throw new Exception("Chyba u mazání příloh: ". $e->getMessage());
        }

        // delete comments
        try {
            $this->databaseConnector->delete(
                "posts_comments",
                "post_id",
                $savedPost["id"]
            );
        } catch (Exception $e) {
            throw new Exception("Chyba u mazání komentářů: ". $e->getMessage());
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
        return $this->databaseConnector->selectOneRow("
            SELECT * FROM posts
            WHERE slug = '" . $this->databaseConnector->escape($slug) . "'"
        ) ?? [];
    }

    /**
     * Inserts or updates attachments for a post
     * @param array $attachments
     * @param int $postId
     * @return void
     * @throws Exception
     */
    private function insertOrUpdateAttachments(array $attachments, int $postId): void
    {
        // delete all attachments if any exist
        try {
            $this->databaseConnector->delete(
                "posts_attachments",
                "post_id",
                $postId
            );
        } catch (Exception $e) {
            throw new Exception("Chyba u mazání příloh: ". $e->getMessage());
        }

        foreach ($attachments as $attachment) {
            $result = [
                "post_id" => $postId,
                "url" => $this->utilityService->normalizeString($attachment),
                "type" => "TBD",
            ];
            try {
                $this->databaseConnector->insert("posts_attachments", $result);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
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