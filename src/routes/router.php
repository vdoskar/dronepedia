<?php
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case "/":
    case "":
        require __DIR__ . "/pages/home.php";
        break;

    default:
        $file = __DIR__ . "/pages" . $request . ".php";
        if (file_exists($file)) {
            require $file;
            break;
        }

        http_response_code(404);
        require __DIR__ . "/pages/404.php";
        break;
}