<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("bgImg", "https://cdn.dronepedia.krisp1k.eu/images/header_home.jpg");
$smarty->assign("title", "Použité zdroje");
$smarty->display("sources.tpl");