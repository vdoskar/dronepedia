<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/knowledge-base");
$smarty->assign("title", "Drony");
$smarty->assign("bgImg", "https://cdn.dronepedia.krisp1k.eu/images/header_drones.webp");
$smarty->display("drones.tpl");