<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("title", "Přihlášení");
$smarty->display("login.tpl");

?>

