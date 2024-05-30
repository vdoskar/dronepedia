<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiProfileController.php';
require_once 'src/services/DatabaseConnector.php';

$apiAuthController = new ApiAuthController();
$profileController = new ApiProfileController();
$databaseConnector = new DatabaseConnector();

$currentUser = $apiAuthController->getCurrentUser();
if (empty($currentUser) || $currentUser["role"] != "ADMIN") {
    header("Location: /");
    exit();
}

$allUsers = $databaseConnector->selectAll("
    SELECT * FROM users
    LEFT JOIN users_logged ON users.uuid = users_logged.user
");

$allPosts = $databaseConnector->selectAll("
    SELECT * FROM posts
    LEFT JOIN users ON posts.author = users.uuid
");

$allComments = $databaseConnector->selectAll("
    SELECT * FROM posts_comments;
");

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/admin");
$smarty->assign("currentUser", $currentUser);
$smarty->assign("users", $allUsers);
$smarty->assign("posts", $allPosts);
$smarty->assign("comments", $allComments);
$smarty->display("dashboard.tpl");
