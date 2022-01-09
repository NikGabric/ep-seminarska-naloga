<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Add a new item</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>
    <p><a href="<?= BASE_URL . "store" ?>">Home</a></p>

    <h1>Add a new item</h1>

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
        <div class="register-box">
            <form action="<?= BASE_URL . "store/addItem" ?>" method="post">
                <p><span>Cube name: </span><input type="text" name="cube_name" autofocus /></p>
                <p><span>Manufacturer: </span><input type="text" name="manufacturer" /></p>
                <p><span>Cube type: </span><input type="text" name="cube_type" /></p>
                <p><span>Price: </span><input type="text" name="price" /></p>
                <p><button>Add</button></p>
            </form>
        </div>
    </div>
</body>