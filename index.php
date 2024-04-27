<?php

// API controllery TBD


$request = $_SERVER['REQUEST_URI'];
if (str_starts_with($request, "/api")) {
    require "src/routes/router_api.php";
    exit();
}

// Smarty
require_once('src/packages/smarty/libs/Smarty.class.php');

//print_r($_SERVER);

?>


<!DOCTYPE html>
<html lang="cs-cz">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex,nofollow" />
    <meta name="author" content="Vladimír Doškář" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="DronePedia - Portál pro dronery a dronové nadšence" />
    <meta name="keywords" content="dron, dronery, dronové, portál, informace, zprávy, novinky, recenze, videa, fotky, dronepedia" />
    <meta name="robots" content="index, follow" />

    <!-- icon -->
    <link rel="icon" href="/src/assets/logo.webp" type="image/webp">

    <!-- title -->
    <title>DronePedia</title>

    <!--  google fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- css atd   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/src/css/styles.css">

    <!--  js  -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js integrity=" sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        -->
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>

    <script src="/src/js/ajax.js"></script>
    <script src="/src/js/tabs.js"></script>
    <script src="/src/js/utils.js"></script>
</head>

<body>
    <div id="bodyLayout">
        <nav class="navbar navbar-dark">
            <?php include_once("src/components/nav.php") ?>
        </nav>
        <main id="bodyMain">
            <div id="pageContent">
                <?php require("src/routes/router.php"); ?>
            </div>
        </main>
        <footer>
            <?php include_once("src/components/footer.php") ?>
        </footer>
    </div>
</body>

<script>
    if (window.location.pathname === "/") {
        document.title = "Domů | DronePedia";
    } else {
        document.title = document.querySelector("h1").innerText + " | DronePedia";
    }
</script>

</html>