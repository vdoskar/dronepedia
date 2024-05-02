<?php

class AdminService
{
    protected DatabaseConnector $databaseConnector;
    protected UtilityService $utilityService;
    protected ApiAuthController $authController;
    protected ApiPostsController $postsController;
    protected ApiProfileController $profileController;
    protected ApiPostsCommentsController $commentsController;

    public function __construct()
    {
        require_once 'src/services/DatabaseConnector.php';
        require_once 'src/services/UtilityService.php';
        require_once 'src/services/Api/ApiAuthController.php';
        require_once 'src/services/Api/ApiPostsController.php';
        require_once 'src/services/Api/ApiProfileController.php';
        require_once 'src/services/Api/ApiPostsCommentsController.php';

        $this->databaseConnector = new DatabaseConnector();
        $this->authController = new ApiAuthController();
        $this->utilityService = new UtilityService();
        $this->postsController = new ApiPostsController();
        $this->profileController = new ApiProfileController();
        $this->commentsController = new ApiPostsCommentsController();
    }
}