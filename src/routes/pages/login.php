<?php

require_once 'src/services/Api/ApiAuthController.php';
$controller = new ApiAuthController();
if (!empty($controller->getCurrentUser())) {
    header("Location: /");
    exit();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("title", "Přihlášení");
$smarty->display("login.tpl");

?>

