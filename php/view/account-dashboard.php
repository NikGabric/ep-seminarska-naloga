<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Account dashboard</title>
</head>

<body>
    <p><a href="<?= BASE_URL . "/store" ?>">Home</a></p>

    <h1>Account dashboard</h1>

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

        <div class="login-box">
            <form action="<?= BASE_URL . "account/" . $_SESSION["user_id"] . "/editUsername" ?>" method="post">
                <input type="hidden" name="id" value="<?= $_SESSION["user_id"] ?>" />
                <p><span>Change username: </span><input type="username" name="username" value="<?= $_SESSION["username"] ?>" /></p>
                <p><button>Update</button></p>
            </form>
        </div>
        <div class="login-box">
            <form action="<?= BASE_URL . "account/" . $_SESSION["user_id"] . "/editPassword" ?>" method="post">
                <input type="hidden" name="id" value="<?= $_SESSION["user_id"] ?>" />
                <p><span>Change password: </span><input type="password" name="password" /></p>
                <p><button>Update</button></p>
            </form>
        </div>

    </div>
</body>

</html>