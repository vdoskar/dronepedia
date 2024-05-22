<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiAuthController.php';

class ApiPostsCommentsController
{
    private DatabaseConnector $databaseConnector;
    private ApiAuthController $authController;

    public function __construct()
    {
        $this->databaseConnector = new DatabaseConnector();
        $this->authController = new ApiAuthController();
    }

    /**
     * Creates a new comment
     * @param array $data
     * @throws Exception
     */
    public function create(array $data): void
    {
        try {
            if (empty($data["post_id"]) ||
                empty($data["comment_content"]) ||
                empty($data["author"])
            ) {
                throw new Exception("Nevyplnil/a jste všechny potřebné údaje.");
            }

            if (!$this->authController->validateLogin()) {
                throw new Exception("Pro editaci příspěvku se musíte přihlásit.");
            }

            $result = [
                "post_id" => $this->databaseConnector->escape($data["post_id"]),
                "content" => $data["comment_content"],
                "author" => $this->databaseConnector->escape($data["author"]),
                "date_created" => date("Y-m-d H:i:s"),
            ];

            $this->databaseConnector->insert(
                table: "posts_comments",
                data: $result
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Deletes a comment
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function delete(array $data): void
    {
    }
}