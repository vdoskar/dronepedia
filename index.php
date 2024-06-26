<?php

// no cache
header('Cache-Control: no-cache');

$request = $_SERVER['REQUEST_URI'];
if (str_starts_with($request, "/api")) {
    if (str_starts_with($request, "/api/admin")) {
        require_once "src/routes/router_api_admin.php";
    } else {
        require_once "src/routes/router_api.php";
    }
    exit();
}

// Connect Smarty
require_once('src/packages/smarty/libs/Smarty.class.php');

?>

<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <!-- meta info -->
    <meta charset="UTF-8">
    <meta name="robots" content="index,follow"/>
    <meta name="author" content="Vladimír Doškář"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DronePedia - Portál pro dronové piloty a nadšence. Semestrální práce pro předmět Vývoj Webových Aplikací bakalářského studijního programu Informační management na EF TUL."/>
    <meta name="keywords"
          content="dron, dronové, portál, informace, zprávy, novinky, recenze, videa, fotky, dronepedia, pilot dronu, provozovatel dronu, dron wikipedie, wikipedie dronů"/>
    <meta name="robots" content="index, follow"/>

    <!-- icon -->
    <link rel="icon" href="https://cdn.dronepedia.krisp1k.eu/favicon/favicon_yellow.svg" type="image/svg">

    <!-- title -->
    <title>DronePedia</title>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">

    <!-- css -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          referrerpolicy="no-referrer"
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="/src/css/styles.css">
    <link rel="stylesheet" href="/src/css/responsive.css">

    <!--  js  -->
    <script src="/src/js/tabs.js"></script>
    <script src="/src/js/utils.js"></script>
    <script src="/src/js/editor.js"></script>
    <script src="/src/js/dialog.js"></script>
    <script src="/src/js/drones.js"></script>
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
</head>

<body>
    <div id="bodyLayout">
        <?php require_once("src/components/nav.php") ?>
        <main id="bodyMain">
            <div id="pageContent">
                <?php require_once("src/routes/router.php"); ?>
            </div>
        </main>
        <footer>
            <?php require_once("src/components/footer.php") ?>
        </footer>
    </div>
</body>

<script>
    utils.setPageTitle();
</script>

</html>