<?php

include_once('src/services/Api/ApiAuthController.php');

$authController = new ApiAuthController();

$loggedIn = false;
$isAdmin = false;
$currentUser = [];
$menu = json_decode(file_get_contents(__DIR__ . '/menu.json'), true);

try {
    $currentUser = $authController->getCurrentUser();
    if (!empty($currentUser)) {
        $loggedIn = true;
        $isAdmin = ($currentUser["role"] == "ADMIN");
    }
} catch (Exception $e) {
    echo $e->getMessage(); die();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/components");
$smarty->assign("loggedIn", $loggedIn);
$smarty->assign("isAdmin", $isAdmin);
$smarty->assign("menu", $menu);
$smarty->assign("activeTab", $_SERVER["REQUEST_URI"]);
$smarty->display("nav.tpl");