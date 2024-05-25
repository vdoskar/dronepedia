<?php

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates");
$smarty->assign("title", "Použité zdroje");
$smarty->display("sources.tpl");