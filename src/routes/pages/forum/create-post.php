<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiAuthController.php';

$authController = new ApiAuthController();

if (!$authController->validateLogin($_COOKIE["SESSION_ID"] ?? "")) {
    header("Location: /login");
    exit();
}

$categories = [
    [
        "id" => 1,
        "name" => "Drony",
    ],
    [
        "id" => 2,
        "name" => "Drony s kamerou",
    ],
    [
        "id" => 3,
        "name" => "Drony s GPS",
    ],
];

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum");
$smarty->assign("categories", $categories);
$smarty->display('create-post.tpl');

