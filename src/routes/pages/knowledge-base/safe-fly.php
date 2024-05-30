<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/knowledge-base");
$smarty->assign("title", "Pravidla bezpečného létání");
$smarty->assign("bgImg", "https://cdn.dronepedia.krisp1k.eu/images/header_safe_fly.webp");
$smarty->display("safe-fly.tpl");