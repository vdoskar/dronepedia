<?php

if (empty($_GET["p"])) {
    header("Location: /forum");
    exit;
}

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiPostsController.php';
require_once 'src/services/Api/ApiAuthController.php';

$databaseConnector = new DatabaseConnector();
$postsController = new ApiPostsController();
$authController = new ApiAuthController();

$currentUser = $authController->getCurrentUser() ?? [];


$post = $databaseConnector->selectOneRow("
    SELECT 
        posts.id, 
        posts.title, 
        posts.content,
        posts.slug, 
        posts.short_summary,
        posts.date_created, 
        posts.category,
        posts.status,
        users.label as author,
        users.username as author_tag
    FROM posts
    INNER JOIN users ON posts.author = users.uuid
    WHERE posts.slug = '" . $_GET["p"] . "'
        AND posts.status = 'ACTIVE'
");

if (empty($post)) {
    header("Location: /forum");
    exit;
}

$comments = $databaseConnector->selectAll("
    SELECT 
        posts_comments.id, 
        posts_comments.content, 
        posts_comments.date_created, 
        users.label as author,
        users.username as author_tag
    FROM posts_comments
    INNER JOIN users ON posts_comments.author = users.uuid
    WHERE posts_comments.post_id = " . $post["id"] . "
    ORDER BY posts_comments.date_created DESC
");



$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum");
$smarty->assign("title", $post["title"]);
$smarty->assign("bgImg", "https://picsum.photos/1920/250");
$smarty->assign("post", $post);
$smarty->assign("comments", $comments);
if (!empty($currentUser)) {
    $smarty->assign("currentUser", $currentUser);
}
$smarty->display("post.tpl");