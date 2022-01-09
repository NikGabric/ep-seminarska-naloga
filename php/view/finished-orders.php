<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Cube store</title>
</head>

<body>
    <p><a href="<?= BASE_URL . "store" ?>">Home</a></p>

    <h1>Finished orders</h1>

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

    <div id="order-main">
        <?php foreach ($orders as $orderId => $orderDetails) : ?>
            <form action="<?= BASE_URL . "store/finishedOrders" ?>" method="post">
                <input type="hidden" name="order_id" value="<?= $orderId ?>" />
                <div class="order" style="text-align: center;">
                    <p><b>Order ID: <?= $orderId ?></b></p>
                    <div>
                        <?php foreach ($orderDetails[$orderId] as $temp => $product) : ?>
                            <div class="cut-text"><?= $product["product_quantity"] ?> x <?= CubeDB::getCubeName(["cube_id" => $product["product_id"]]); ?></div>
                        <?php endforeach; ?>
                        <div style="text-align: center;">Order status: <u><?= $orderDetails["order_status"] ?></u></div>
                        <div style="text-align: center;">Order total: <b><?= $orderDetails["order_total"] ?> EUR</b></div>
                    </div>
                    <p>
                        <span>Update status:</span>
                        <select name="order_status">
                            <option value="pending" selected>Pending</option>
                            <option value="confirmed">Confirm</option>
                            <option value="cancelled">Cancel</option>
                            <option value="reversed">Reverse</option>
                        </select>
                    </p>
                    <p><button>Update</button></p>
                </div>
            </form>
    </div>

<?php endforeach; ?>
</div>
</body>

</html>