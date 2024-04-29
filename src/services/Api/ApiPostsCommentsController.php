<?php

class ApiPostsCommentsController
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
        if (empty($data["post_id"]) ||
            empty($data["comment_content"]) ||
            empty($data["author"])
        ) {
            throw new Exception("Missing required fields", 400);
        }

        $result = [
            "post_id" => $this->databaseConnector->escape($data["post_id"]),
            "content" => $data["comment_content"],
            "author" => $this->databaseConnector->escape($data["author"]),
            "date_created" => date("Y-m-d H:i:s"),
        ];

        $this->databaseConnector->insert("posts_comments", $result);
    }

    public function edit(array $data): void
    {

    }

    public function delete(array $data): void
    {

    }
}