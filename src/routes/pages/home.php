<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("bgImg", "https://cdn.dronepedia.krisp1k.eu/images/header_home.webp");
$smarty->display("home.tpl");