<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/knowledge-base");
$smarty->assign("title", "Znalostní báze");
$smarty->assign("bgImg", "https://picsum.photos/1920/250");
$smarty->display("index.tpl");