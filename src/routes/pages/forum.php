<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiPostsController.php';
require_once 'src/services/Api/ApiAuthController.php';

$databaseConnector = new DatabaseConnector();
$postsController = new ApiPostsController();
$authController = new ApiAuthController();

$currentUser = $authController->getCurrentUser() ?? [];

$myPosts = [];
if (!empty($currentUser)) {
    $myPosts = $databaseConnector->selectAll("
        SELECT posts.title, 
               posts.short_summary,
               posts.slug, 
               posts.date_created, 
               posts.category,
               posts.status,
               users.username as author,
               users_settings.pic_profile as author_avatar
        FROM posts
        LEFT JOIN users ON posts.author = users.uuid
        LEFT JOIN users_settings ON users.uuid = users_settings.user
        WHERE posts.author = '" . $currentUser["uuid"] . "'
            AND posts.status = 'ACTIVE'
        ORDER BY posts.date_created DESC
        LIMIT 10
    ") ?? [];
}

$latestPosts = $databaseConnector->selectAll("
     SELECT posts.title, 
            posts.short_summary,
            posts.slug, 
            posts.date_created, 
            posts.category,
            posts.status,
            users.username as author,
            users_settings.pic_profile as author_avatar
    FROM posts
    LEFT JOIN users ON posts.author = users.uuid
    LEFT JOIN users_settings ON users.uuid = users_settings.user
    ORDER BY posts.date_created DESC
    LIMIT 10
") ?? [];

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum");
$smarty->assign("title", "Komunitní fórum");
$smarty->assign("bgImg", "https://cdn.dronepedia.krisp1k.eu/images/header_forum.webp");
$smarty->assign("latestPosts", $latestPosts);
$smarty->assign("myPosts", $myPosts);
$smarty->assign("currentUser", $currentUser ?? null);
$smarty->display("index.tpl");