<?php
require("../lib/get-session-vars.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Inventory Manager</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta id="fileName" content="scan.php">

    <?php
    require("../lib/frontend/import.html");
    ?>
</head>

<body>
    <?php require("../lib/frontend/header.html"); ?>

    <div class="wrapper">
        <?php
        if ($status == '') {
            require("../lib/frontend/scanning.php");
            // TODO: item lookup
        } elseif ($status == 'info') {
            require("../lib/frontend/display_info_scan.php");
        } elseif ($status == 'success') {
            require("../lib/frontend/success_scan.php");
        } else {
            $err_msg = 'Invalid status "' . $status . '"';
            $_SESSION = [];
        }
        require("../lib/frontend/error.php");
        ?>
    </div>

    <footer>
        <nav>
            <a href="recover-item.php">
                <i class="fa fa-fw fa-reply nav--icon"></i>
            </a>
            <a href="scan.php">
                <i class="fa fa-fw fa-qrcode nav--icon nav--icon--current"></i>
            </a>
            <a href="remove-item.php">
                <i class="fa fa-fw fa-trash nav--icon"></i>
            </a>
        </nav>
    </footer>
</body>

</html>