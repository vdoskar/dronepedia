<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Admin/AdminPostsService.php';

$adminPostsService = new AdminPostsService();
$authController = new ApiAuthController();

$currentUser = $authController->getCurrentUser();
if ($currentUser["role"] != "ADMIN") {
    header("Location: /");
    exit();
}

$requestFull = explode("?", $_SERVER["REQUEST_URI"]);
$request = $requestFull[0];

switch ($request) {
    case '/api/admin/post/close':
        $adminPostsService->close($_GET['p']);
        header("Location: /admin#tab_posts");
        break;

    case '/api/admin/post/open':
        $adminPostsService->open($_GET['p']);
        header("Location: /admin#tab_posts");
        break;

    case '/api/admin/post/delete':
        $adminPostsService->delete($_GET['p']);
        header("Location: /admin#tab_posts");
        break;
}