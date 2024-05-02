<?php

require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/Api/ApiPostsController.php';

$authController = new ApiAuthController();
$postsController = new ApiPostsController();

if (!$authController->validateLogin()) {
    header("Location: /login");
    exit();
}

$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/forum/post");
$smarty->assign("categories", $postsController->categories);
$smarty->display('create-post.tpl');

