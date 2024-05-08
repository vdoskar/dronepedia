<?php

require_once 'src/services/Api/ApiAuthController.php';

$apiAuthController = new ApiAuthController();

// if the user is not logged in, they cannot add a drone
$currentUser = $apiAuthController->getCurrentUser();
if (empty($currentUser)) {
    header("Location: /login");
    exit();
}


$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile/drones");
$smarty->assign("currentUser", $currentUser);
$smarty->display("add-drone.tpl");