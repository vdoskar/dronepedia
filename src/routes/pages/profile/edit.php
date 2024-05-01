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

$settings = $profileController->getUserSettings($currentUser["uuid"]);

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile");
$smarty->assign("currentUser", $currentUser);
$smarty->assign("settings", $settings);
$smarty->display("edit.tpl");