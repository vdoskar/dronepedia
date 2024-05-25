<?php

$images = [
    "drones" => "https://cdn.dronepedia.krisp1k.eu/images/knowledge_base_drones.webp",
    "safe_fly" => "https://cdn.dronepedia.krisp1k.eu/images/knowledge_base_safe_fly.webp",
];

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/knowledge-base");
$smarty->assign("title", "Znalostní báze");
$smarty->assign("images", $images);
$smarty->display("index.tpl");