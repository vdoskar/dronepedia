<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum");
$smarty->assign("title", "Komunitní fórum");
$smarty->assign("bgImg", "https://picsum.photos/1920/250");
$smarty->display("index.tpl");

?>