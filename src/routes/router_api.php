<?php

global $request;

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiPostsController.php';
require_once 'src/services/Api/ApiProfileController.php';

$authController = new ApiAuthController();
$postsController = new ApiPostsController();
$profileController = new ApiProfileController();

switch ($request) {

    //
    // AUTHENTICATION
    //

    // REGISTER TO THE WEBSITE
    case "/api/auth/register":
        $authController->register($_POST);
        header("Location: /"); // return to main page
        break;

    // LOGIN TO THE WEBSITE
    case "/api/auth/login":
        $authController->login($_POST);
        header("Location: /"); // return to main page
        break;

    // LOGOUT FROM THE WEBSITE
    case "/api/auth/logout":
        $authController->logout();
        break;

    //
    // POSTS
    //


    // CREATE A NEW POST
    case "/api/posts/create":
        $postsController->create($_POST);
        header("Location: /forum"); // return to main page
        break;
}
