<?php

global $request;

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiPostsController.php';
require_once 'src/services/Api/ApiProfileController.php';
require_once 'src/services/Api/ApiPostsCommentsController.php';
require_once 'src/services/DatabaseConnector.php';

$authController = new ApiAuthController();
$postsController = new ApiPostsController();
$profileController = new ApiProfileController();
$commentsController = new ApiPostsCommentsController();
$databaseController = new DatabaseConnector();

switch ($request) {
    //
    // AUTHENTICATION
    //

    // REGISTER TO THE WEBSITE
    case "/api/auth/register":
        $authController->register($_POST);
        header("Location: /");
        break;

    // LOGIN TO THE WEBSITE
    case "/api/auth/login":
        $authController->login($_POST);
        header("Location: /");
        break;

    // LOGOUT FROM THE WEBSITE
    case "/api/auth/logout":
        $authController->logout();
        header("Location: /");
        break;


    //
    // POSTS
    //

    // CREATE A NEW POST
    case "/api/posts/create":
        $slug = $databaseController->escape($_POST["slug"]);
        $postsController->create($_POST);
        header("Location:/forum/post?p=" . $slug);
        break;

    // EDIT A POST
    case "/api/posts/edit":
        $slug = $databaseController->escape($_POST["slug"]);
        $postsController->edit($slug, $_POST);
        header("Location: /forum/post?p=" . $slug);
        break;

    // DELETE A POST
    case "/api/posts/delete":
        $postsController->delete($_POST["slug"]);
        header("Location: /forum");
        break;


    //
    // POST COMMENTS
    //

    // CREATE A NEW COMMENT
    case "/api/posts/comments/create":
        $commentsController->create($_POST);
        header("Location: " . ($_POST["redirectUrl"] ?? "/forum"));
        break;

    // EDIT A COMMENT
    //    case "/api/posts/comments/edit":
    //        $commentsController->edit($_POST);
    //        header("Location: /forum");
    //        break;

    // DELETE A COMMENT
    case "/api/posts/comments/delete":
        $commentsController->delete($_POST);
        header("Location: /forum");
        break;


    //
    // PROFILE
    //

    // CHANGE EMAIL
    case "/api/profile/contacts/change-email":
        $profileController->changeEmail($_POST["new_email"]);
        header("Location: /profile/edit");
        break;

    // CHANGE PASSWORD
    case "/api/profile/contacts/change-password":
        $profileController->changePassword($_POST["new_password"]);
        header("Location: /profile/edit");
        break;

    // CHANGE NAME
    case "/api/profile/contacts/change-name":
        $profileController->changeName($_POST["new_name"]);
        header("Location: /profile/edit");
        break;

    // CHANGE PROFILE SETTINGS
    case "/api/profile/settings/change":
        $profileController->changeSettings($_POST);
        header("Location: /profile/edit");
        break;

    // ADD NEW DRONE
    case "/api/profile/drones/add":
        $profileController->droneAdd($_POST);
        header("Location: /profile");
        break;


    // EDIT DRONE
    case "/api/profile/drones/edit":
        $profileController->droneEdit($_POST);
        header("Location: /profile");
        break;


    // DELETE DRONE
    case "/api/profile/drones/delete":
        $profileController->droneDelete($_POST["drone_id"]);
        header("Location: /profile");
        break;
}