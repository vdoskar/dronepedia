<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiPostsController.php';

$authController = new ApiAuthController();
$databaseConnector = new DatabaseConnector();
$postsController = new ApiPostsController();

$currentUser = $authController->getCurrentUser();
if (empty($currentUser) || empty($_GET["p"])) {
    header("Location: /login");
    exit();
}

$post = $databaseConnector->selectOneRow("
    SELECT 
        p.id, 
        p.title, 
        p.content,
        p.slug, 
        p.short_summary,
        p.date_created, 
        p.category,
        p.author
    FROM posts p
    WHERE p.slug = '" . $databaseConnector->escape($_GET["p"]) . "'
");

if ($post["author"] != $currentUser["uuid"]) {
    header("Location: /forum");
    exit();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum/post");
$smarty->assign("categories", $postsController->categories);
$smarty->assign("post", $post);
$smarty->display('edit-post.tpl');

