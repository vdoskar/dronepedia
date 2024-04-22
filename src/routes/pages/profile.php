<?php

$user = [
    "profile_picture" => "https://picsum.photos/250/250",
    "header_picture" => "https://picsum.photos/1920/250",
    "username" => "johndoe",
    "name" => "John Doe",
    "registered" => "2021-01-01",
    "last_login" => "2021-01-01",
    "post_count" => 1651,
    "comment_count" => 50,
];

$userDrones = [
    [
        "name" => "Drone 1",
        "model" => "Model 1",
        "status" => "active"
    ], 
    [
        "name" => "Drone 2",
        "model" => "Model 2",
        "status" => "inactive"
    ], 
    [
        "name" => "Drone 3",
        "model" => "Model 3",
        "status" => "active"
    ]
];

$userPosts = [
    [
        "title" => "Post 1",
        "content" => "Content 1",
        "created_at" => "2021-01-01",
        "status" => "active"
    ], 
    [
        "title" => "Post 2",
        "content" => "Content 2",
        "created_at" => "2021-01-01",
        "status" => "inactive"
    ], 
    [
        "title" => "Post 3",
        "content" => "Content 3",
        "created_at" => "2021-01-01",
        "status" => "active"
    ]
];


$smarty = new Smarty();
$smarty->setTemplateDir("src/routes/templates/profile");
$smarty->assign("user", $user);
$smarty->assign("drones", $userDrones);
$smarty->assign("posts", $userPosts);
$smarty->display("item.tpl");

?>
