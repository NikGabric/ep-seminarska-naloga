<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Cube store</title>
</head>

<body>
    <p><a href="<?= BASE_URL . "store" ?>">Home</a></p>

    <h1>Cube store</h1>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        if ($_SESSION["role"] == "seller") { ?>
            <p>[
                <span><a href="<?= BASE_URL . "account/" . $_SESSION["user_id"] ?>"><?= $_SESSION["username"] ?></a></span> |
                <span><a href="<?= BASE_URL . "logout" ?>">Logout</a></span> |
                <span><a href="<?= BASE_URL . "store/finishedOrders" ?>">View finished orders</a></span>
                ]
            </p>
        <?php } else if ($_SESSION["role"] == "customer") { ?>
            <p>[
                <span><a href="<?= BASE_URL . "account/" . $_SESSION["user_id"] ?>"><?= $_SESSION["username"] ?></a></span> |
                <span><a href="<?= BASE_URL . "logout" ?>">Logout</a></span> |
                <span><a href="<?= BASE_URL . "store/viewCustomerOrders" ?>">View my orders</a></span>
                ]
            </p>
        <?php } else if ($_SESSION["role"] == "admin") { ?>
            <p>[
                <span><a href="<?= BASE_URL . "account/" . $_SESSION["user_id"] ?>"><?= $_SESSION["username"] ?></a></span> |
                <span><a href="<?= BASE_URL . "logout" ?>">Logout</a></span> |
                <a href="<?= BASE_URL . "account/adminPanel" ?>">Admin panel</a>
                ]
            </p>
        <?php  } ?>
    <?php } else { ?>
        <p>[
            <span><a href="<?= BASE_URL . "login" ?>">Login</a></span> |
            <span><a href="<?= BASE_URL . "register" ?>">Register</a></span>
            ]
        </p>
    <?php } ?>

    <div id="main">
        <?php foreach ($cubes as $cube) : ?>
            <div class="cube">
                <form action="<?= BASE_URL . "store/addToCart" ?>" method="post">
                    <input type="hidden" name="cube_id" value="<?= $cube["cube_id"] ?>" />
                    <p><?= $cube["manufacturer"] ?>: <?= $cube["cube_name"] ?></p>
                    <p><?= number_format($cube["price"], 2) ?> EUR<br />
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["role"] == "customer") { ?>
                            <button type="submit">V košarico</button>
                        <?php } ?>
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
                    <input type="hidden" name="cube_id" value="<?= $id ?>" />
                    <input type="number" name="quantity" style="width:50px;  float: left;" min="0" value="<?= $value ?>" />
                    <div class="cut-text"> x <?= CubeDB::getCubeName(["cube_id" => $id]); ?></div>
                    <button type="submit" style="float:right;">Update</button>
                </form>
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
            <form action="<?= BASE_URL . "store/finishOrder" ?>" method="get">
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