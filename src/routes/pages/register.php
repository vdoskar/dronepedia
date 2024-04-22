<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("title", "Registrace na DronoPedii");
$smarty->display("register.tpl");

?>
