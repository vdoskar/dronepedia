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

    }

    public function edit(array $data): void
    {

    }

    public function delete(array $data): void
    {

    }
}