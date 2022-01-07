<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Cube store</title>
</head>

<body>
    <p><a href="home">Home</a></p>

    <h1>Cube store</h1>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
        <p>[
            <span><a href="<?= BASE_URL . "account/" . $_SESSION["id"] ?>"><?= $_SESSION["username"] ?></a></span> |
            <span><a href="<?= BASE_URL . "logout" ?>">Logout</a></span>
            ]
        </p>
    <?php  } else { ?>
        <p>[
            <span><a href="<?= BASE_URL . "login" ?>">Login</a></span> |
            <span><a href="<?= BASE_URL . "register" ?>">Register</a></span>
            ]
        </p>
    <?php } ?>

    <p>[
        <a href="<?= BASE_URL . "store" ?>">All cubes</a> |
        <a href="<?= BASE_URL . "store/add" ?>">Add new</a>
        ]
    </p>

    <div id="main">
        <?php foreach ($cubes as $cube) : ?>
            <div class="cube">
                <form action="<?= BASE_URL . "store/addToCart" ?>" method="post">
                    <input type="hidden" name="id" value="<?= $cube["id"] ?>" />
                    <p><?= $cube["manufacturer"] ?>: <?= $cube["cube_name"] ?></p>
                    <p><?= number_format($cube["price"], 2) ?> EUR<br />
                        <button type="submit">V košarico</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['role'] == "customer") { ?>
        <div class="cart">
            <h3>Košarica</h3>
            <p><?php
                if (!empty($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $id => $value) : ?>
            <div style="width: 100%; overflow: hidden;">
                <form action="<?= BASE_URL . "store/updateCart" ?>" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>" />
                    <input type="number" name="quantity" style="width:50px;  float: left;" min="0" value="<?= $value ?>" />
                    <div class="cut-text"> x <?= CubeDB::getCubeName(["id" => $id]); ?></div>
                    <button type="submit" style="float:right;">Update</button>
                </form>
                <!-- <button type="submit" style="float:right;">Posodobi</button> -->
                <!-- </form> -->
            </div>
        <?php
                    endforeach;
        ?>
        <div>Total: <b><?= number_format(Cart::total(), 2) ?> EUR</b></div>
        <div>
            <form action="<?= BASE_URL . "store/purgeCart" ?>" method="post">
                <input type="hidden" name="do" value="purge_cart" />
                <button type="submit">Empty cart</button>
            </form>
        </div>
        <div>
            <form action="<?= BASE_URL . "store/finishOrder" ?>" method="post">
                <button type="submit">Finish order</button>
            </form>
        </div>
    <?php } ?>



<?php
    } else {
        echo "Cart is empty.";
    }
?></p>
        </div>
</body>

</html>