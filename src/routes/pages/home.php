<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("bgImg", "https://picsum.photos/1920/850");
$smarty->display("home.tpl");