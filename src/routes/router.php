<?php

$request = $_SERVER['REQUEST_URI'];
// get rid of GET parameters if they exist
$request = explode("?", $request)[0];

switch ($request) {
    case "/":
    case "":
        http_response_code(200);
        require __DIR__ . "/pages/home.php";
        break;

    default:
        $file = __DIR__ . "/pages" . $request . ".php";
        if (file_exists($file)) {
            http_response_code(200);
            require $file;
            break;
        }

        http_response_code(404);
        require __DIR__ . "/pages/404.php";
        break;
}