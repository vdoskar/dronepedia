<?php

class ApiPostsController
{
    private DatabaseConnector $databaseConnector;
    private ApiAuthController $authController;

    public function __construct()
    {
        require_once 'src/services/DatabaseConnector.php';
        require_once 'src/services/Api/ApiAuthController.php';

        $this->databaseConnector = new DatabaseConnector();
        $this->authController = new ApiAuthController();
    }
    public function create(array $data): void
    {
        if (empty($data["slug"]) ||
            empty($data["title"]) ||
            empty($data["short_summary"]) ||
            empty($data["content"]) ||
            empty($data["category"])
        ) {
            throw new Exception("Nevyplnil/a jste všechny potřebné informace");
        }

        if (!$this->authController->validateLogin($_COOKIE["SESSION_ID"])) {
            throw new Exception("Pro vytvoření příspěvku se musíte přihlásit.");
        }

        $slug = $data["slug"];
        if (!$this->isSlugAvailable($slug)) {
            $slug = $data["slug"] . "-" . rand(999, 9999);
        }

        // save to db
        $result = [
            "slug" => $slug,
            "title" => $data["title"],
            "short_summary" => $data["short_summary"] ?? "",
            "author" => $this->authController->getCurrentUser()["uuid"] ?? throw new Exception("Current user not found, cannot save."),
            "content" => $data["content"],
            "category" => $data["category"],
            "date_created" => date("Y-m-d H:i:s"),
            "status" => "ACTIVE",
        ];

        try {
            $this->databaseConnector->insert("posts", $result);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $attachments = $data["attachments"] ?? [];
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $result = [
                    "post_id" => $this->getPostBySlug($slug)["id"],
                    "url" => $attachment,
                    "type" => "TBD",
                ];
                try {
                    $this->databaseConnector->insert("posts_attachments", $result);
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
        }
    }

    public function getPostBySlug(string $slug): array
    {
        return $this->databaseConnector->selectOneRow("
            SELECT * FROM posts
            WHERE slug = '" . $this->databaseConnector->escape($slug) . "'"
        ) ?? [];
    }

    private function isSlugAvailable(string $slug): bool
    {
        return empty($this->getPostBySlug($slug));
    }
}