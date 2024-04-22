<?php

include_once('src/services/Api/AuthController.php');

$loggedIn = true;
$authController = new AuthController();
$menu = json_decode(file_get_contents(__DIR__ . '/menu.json'), true);

try {
    if ($authController->validateLoginState()) {
        $loggedIn = true;
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/components");
$smarty->assign("loggedIn", $loggedIn);
$smarty->assign("menu", $menu);
$smarty->assign("activeTab", $_SERVER["REQUEST_URI"]);
$smarty->display("nav.tpl");