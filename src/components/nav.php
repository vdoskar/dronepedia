<?php

include_once('src/services/Api/ApiAuthController.php');

$authController = new ApiAuthController();

$loggedIn = false;
$menu = json_decode(file_get_contents(__DIR__ . '/menu.json'), true);

try {
    if ($authController->validateLogin()) {
        $loggedIn = true;
    }
} catch (Exception $e) {
    echo $e->getMessage(); die();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/components");
$smarty->assign("loggedIn", $loggedIn);
$smarty->assign("menu", $menu);
$smarty->assign("activeTab", $_SERVER["REQUEST_URI"]);
$smarty->display("nav.tpl");