<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("title", "Registrace na DronePedii");
$smarty->display("register.tpl");

?>
