<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/knowledge-base");
$smarty->assign("title", "Drony");
$smarty->assign("bgImg", "https://picsum.photos/1920/250");
$smarty->display("drones.tpl");

?>