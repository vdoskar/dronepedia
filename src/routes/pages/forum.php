<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiPostsController.php';
require_once 'src/services/Api/ApiAuthController.php';

$databaseConnector = new DatabaseConnector();
$postsController = new ApiPostsController();
$authController = new ApiAuthController();

$myPosts = [];
$authController->validateLogin($_COOKIE["SESSION_ID"]);
if (!empty($authController->getCurrentUser())) {
    $myPosts = $databaseConnector->selectAll("
        SELECT posts.title, 
               posts.short_summary,
               posts.slug, 
               posts.date_created, 
               posts.category,
               posts.status,
               users.username as author
        FROM posts
        INNER JOIN users ON posts.author = users.uuid
        WHERE posts.author = '" . $authController->getCurrentUser()["uuid"] . "'
            AND posts.status = 'ACTIVE'
        ORDER BY posts.date_created DESC
    ");
}

$latestPosts = $databaseConnector->selectAll("
     SELECT posts.title, 
            posts.short_summary,
            posts.slug, 
            posts.date_created, 
            posts.category,
            posts.status,
            users.username as author
    FROM posts
    INNER JOIN users ON posts.author = users.uuid
    ORDER BY posts.date_created DESC
");

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum");
$smarty->assign("title", "Komunitní fórum");
$smarty->assign("bgImg", "https://picsum.photos/1920/250");
$smarty->assign("latestPosts", $latestPosts);
$smarty->assign("myPosts", $myPosts);
$smarty->display("index.tpl");

?>