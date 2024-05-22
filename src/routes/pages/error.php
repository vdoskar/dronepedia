<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("error", $_GET["error"] ?? "Neznámo");
$smarty->display("error.tpl");