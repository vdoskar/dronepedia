<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/DatabaseConnector.php';

$apiAuthController = new ApiAuthController();
$databaseConnector = new DatabaseConnector();

// if the user is not logged in, they cannot add a drone
$currentUser = $apiAuthController->getCurrentUser();
if (empty($currentUser)) {
    header("Location: /login");
    exit();
}

$drone = $databaseConnector->selectOneRow("
    SELECT * FROM users_drones 
    WHERE id = '" . $databaseConnector->escape($_GET['id']) . "'"
) ?? [];

if (empty($drone) || $drone["owner"] != $currentUser["uuid"]) {
    header("Location: /profile");
    exit();
}

$drone["drone_params"] = json_decode($drone["drone_params"], true) ?? [];

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile/drones");
$smarty->assign("currentUser", $currentUser);
$smarty->assign("drone", $drone);
$smarty->display("edit-drone.tpl");