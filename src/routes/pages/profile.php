<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiProfileController.php';

$apiAuthController = new ApiAuthController();
$profileController = new ApiProfileController();

// if the user is not logged in, they cannot access the profile page for themselves or others
if (empty($apiAuthController->getCurrentUser())) {
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
    $user = $apiAuthController->getCurrentUser();
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

$userPosts = [
    "posts" => [],
    "count" => 150
];

$userComments = [
    "comments" => [],
    "count" => 1250
];

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile");
$smarty->assign("user", $user);
$smarty->assign("settings", $userSettings);
$smarty->assign("drones", $userDrones);
$smarty->assign("posts", $userPosts);
$smarty->assign("comments", $userComments);
$smarty->display("item.tpl");

?>
