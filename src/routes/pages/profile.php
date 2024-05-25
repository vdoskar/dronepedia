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

try {
    $userSettings = $profileController->getUserSettings($user["uuid"]);
    $userDrones = $profileController->getUserDrones($user["uuid"]);
    $userPosts = $profileController->getUserPosts($user["uuid"]);
    $userComments = $profileController->getUserComments($user["uuid"]);
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile");
$smarty->assign("user", $user);
$smarty->assign("currentUser", $currentUser);
$smarty->assign("settings", $userSettings);
$smarty->assign("drones", $userDrones);
$smarty->assign("posts", $userPosts);
$smarty->assign("comments", $userComments);
$smarty->display("item.tpl");