<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiProfileController.php';
require_once 'src/services/DatabaseConnector.php';

$apiAuthController = new ApiAuthController();
$profileController = new ApiProfileController();
$databaseConnector = new DatabaseConnector();

// if the user is not logged in, they cannot access the profile page for themselves or others
$currentUser = $apiAuthController->getCurrentUser();
if (empty($currentUser)) {
    header("Location: /login");
    exit();
}

if (!empty($_GET["u"])) {
    $user = $profileController->getUserByUsername($_GET["u"]);
    if (empty($user)) {
        echo "Uživatel nenalezen.";
        return;
    }
} else {
    $user = $currentUser;
}

$userSettings = $profileController->getUserSettings($user["uuid"]);
$userDrones = $profileController->getUserDrones($user["uuid"]);
$userPosts = $profileController->getUserPosts($user["uuid"]);

if (empty($userSettings)) {
    $userSettings = [
        "pic_profile" => "https://www.ef.tul.cz/content/files/images/zamestnanci/135-th.jpg",
        "pic_banner" => "https://www.ef.tul.cz/content/files/images/PAGES/uvod-1672665996-7003.jpg",
    ];
}

$userComments = $databaseConnector->selectAll("
    SELECT 
        c.id, 
        c.content, 
        c.date_created, 
        c.post_id, 
        c.author
    FROM posts_comments c
    WHERE c.author = '" . $user["uuid"] . "'
");

$userPosts = $databaseConnector->selectAll("
    SELECT 
        p.id, 
        p.title, 
        p.slug, 
        p.short_summary, 
        p.date_created, 
        p.category
    FROM posts p
    WHERE p.author = '" . $user["uuid"] . "'
");

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile");
$smarty->assign("user", $user);
$smarty->assign("currentUser", $currentUser);
$smarty->assign("settings", $userSettings);
$smarty->assign("drones", $userDrones);
$smarty->assign("posts", $userPosts);
$smarty->assign("comments", $userComments);
$smarty->display("item.tpl");

?>
