<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Cube store</title>
</head>

<body>
    <p><a href="<?= BASE_URL . "/store" ?>">Home</a></p>

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

    <div class="register-box">
        <h3>List of sellers:</h3>
        <?php foreach ($sellers as $seller) : ?>
            <?php if ($seller["status"] == "active") { ?>
                <form action="<?= BASE_URL . "account/" . $seller["user_id"] . "/updateStatus" ?>" method="post">
                    <input type="hidden" name="user_id" value="<?= $seller["user_id"] ?>" />
                    <input type="hidden" name="status" value="disabled" />
                    <p><span>Username: <?= $seller["username"] ?> </span></p>
                    <p><span>Status: <?= $seller["status"]; ?></span></p>
                    <p><button>Disable</button></p>
                </form>
            <?php } else { ?>
                <form action="<?= BASE_URL . "account/" . $seller["user_id"] . "/updateStatus" ?>" method="post">
                    <input type="hidden" name="user_id" value="<?= $seller["user_id"] ?>" />
                    <input type="hidden" name="status" value="active" />
                    <p><span>Username: <?= $seller["username"] ?> </span></p>
                    <p><span>Status: <?= $seller["status"]; ?></span></p>
                    <p><button>Activate</button></p>
                </form>
            <?php } ?>
        <?php endforeach; ?>
    </div>

    <div class="register-box">
        <p>Create a new seller:</p>
        <form action="<?= BASE_URL . "account/adminPanel/createNewUser" ?>" method="post">
            <input type="hidden" name="status" value="active" />
            <input type="hidden" name="role" value="seller" />
            <p><span>Name: </span><input type="name" name="name" autofocus /></p>
            <p><span>Surname: </span><input type="name" name="surname" /></p>
            <p id="address" hidden><span>Address: </span><input type="text" name="address" value="" /></p>
            <p><span>Email: </span><input type="email" name="email" /></p>
            <p><span>Username: </span><input type="username" name="username" /></p>
            <p><span>Password: </span><input type="password" name="password" /></p>
            <p><span>Password: </span><input type="password" name="password" /></p>
            <p><button>Register</button></p>
        </form>
    </div>