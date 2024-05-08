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
    WHERE p.slug = '" . $_GET["p"] . "'
");

if ($post["author"] != $currentUser["uuid"]) {
    header("Location: /forum");
    exit();
}

$attachments = $databaseConnector->selectAll("
    SELECT 
        pa.id, 
        pa.type, 
        pa.url
    FROM posts_attachments pa
    WHERE pa.post_id = " . $post["id"]
);

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum/post");
$smarty->assign("categories", $postsController->categories);
$smarty->assign("post", $post);
$smarty->assign("attachments", $attachments);
$smarty->display('edit-post.tpl');

