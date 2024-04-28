<?php

global $request;

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiPostsController.php';
require_once 'src/services/Api/ApiProfileController.php';
require_once 'src/services/Api/ApiPostsCommentsController.php';

$authController = new ApiAuthController();
$postsController = new ApiPostsController();
$profileController = new ApiProfileController();
$commentsController = new ApiPostsCommentsController();

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
        header("Location: /"); // return to main page
        break;


    //
    // POSTS
    //

    // CREATE A NEW POST
    case "/api/posts/create":
        $postsController->create($_POST);
        header("Location: /forum"); // return to main page
        break;

    // EDIT A POST
    case "/api/posts/edit":
        $postsController->edit($_POST);
        header("Location: /forum");
        break;

    // DELETE A POST
    case "/api/posts/delete":
        $postsController->delete($_POST);
        header("Location: /forum");
        break;


    //
    // POST COMMENTS
    //

    // CREATE A NEW COMMENT
    case "/api/posts/comments/create":
        $commentsController->create($_POST);
        header("Location: /forum");
        break;

    // EDIT A COMMENT
    case "/api/posts/comments/edit":
        $commentsController->edit($_POST);
        header("Location: /forum");
        break;

    // DELETE A COMMENT
    case "/api/posts/comments/delete":
        $commentsController->delete($_POST);
        header("Location: /forum"); // return to main page
        break;
}