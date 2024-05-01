<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiPostsController.php';

$authController = new ApiAuthController();
$databaseConnector = new DatabaseConnector();
$postsController = new ApiPostsController();

if (!$authController->validateLogin()) {
    header("Location: /login");
    exit();
}

if (empty($_GET["p"])) {
    header("Location: /forum");
    exit;
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

$attachments = $databaseConnector->selectAll("
    SELECT 
        pa.id, 
        pa.type, 
        pa.url
    FROM posts_attachments pa
    WHERE pa.post_id = " . $post["id"]
);


$categories = [
    [
        "id" => 1,
        "name" => "Drony",
    ],
    [
        "id" => 2,
        "name" => "Drony s kamerou",
    ],
    [
        "id" => 3,
        "name" => "Drony s GPS",
    ],
];

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum");
$smarty->assign("categories", $categories);
$smarty->assign("post", $post);
$smarty->assign("attachments", $attachments);
$smarty->display('edit-post.tpl');

