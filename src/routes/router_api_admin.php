<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Admin/AdminPostsService.php';
require_once 'src/services/Admin/AdminUserService.php';

$adminPostsService = new AdminPostsService();
$authController = new ApiAuthController();
$adminUserService = new AdminUserService();

// Check if the logged user is really admin
$currentUser = $authController->getCurrentUser();
if ($currentUser["role"] != "ADMIN") {
    header("Location: /");
    exit();
}

$requestFull = explode("?", $_SERVER["REQUEST_URI"]);
$request = $requestFull[0];

switch ($request) {

    case '/api/admin/user/save-all':
        $adminUserService->saveAll($_POST["user_data"]);
        header("Location: /admin#tab_users");
        break;

    case '/api/admin/post/save-all':
        $adminPostsService->saveAll($_POST["post_data"]);
        header("Location: /admin#tab_posts");
        break;
}