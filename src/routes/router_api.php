<?php

global $request;

use services\Api\AuthController;
use services\Api\PostsController;
use services\Api\ProfileController;

require_once 'src/services/Api/AuthController.php';
require_once 'src/services/Api/PostsController.php';
require_once 'src/services/Api/ProfileController.php';

$authController = new AuthController();
$postsController = new PostsController();
$profileController = new ProfileController();

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

switch ($request) {
    case "/api/auth/register":
        try {
            $authController->register($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case "/api/auth/check-availible-registration":
        try {
            $email = "test@4trans.cz";
            $authController->checkAvailibleRegistration($email);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case "/api/posts/create":
        $postsController->create($data);
        break;

    case "/api/profile/update-name":
        $profileController->updateName($data);
        break;
}
