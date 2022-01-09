<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Register</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>
    <p><a href="<?= BASE_URL . "store" ?>">Home</a></p>

    <h1>Register</h1>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        if ($_SESSION["role"] == "seller") { ?>
            <p>[
                <span><a href="<?= BASE_URL . "account/" . $_SESSION["user_id"] ?>"><?= $_SESSION["username"] ?></a></span> |
                <span><a href="<?= BASE_URL . "logout" ?>">Logout</a></span> |
                <span><a href="<?= BASE_URL . "store/finishedOrders" ?>">View finished orders</a></span> |
                <span><a href="<?= BASE_URL . "store/addItem" ?>">Add new item</a></span>
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
            <form action="<?= BASE_URL . "register" ?>" method="post">
                <input type="hidden" name="status" value="active" />
                <p>
                    <span>Account role:</span>
                    <select name="role" onchange="hideAddress(this.value)">
                        <option value="seller" selected>Seller</option>
                        <!-- <option value="admin">Admin</option> -->
                        <option value="customer">Customer</option>
                    </select>
                </p>
                <p><span>Name: </span><input type="name" name="name" autofocus /></p>
                <p><span>Surname: </span><input type="name" name="surname" /></p>
                <p id="address" hidden><span>Address: </span><input type="text" name="address" value="" /></p>
                <p><span>Email: </span><input type="email" name="email" value="<?= $email ?>" /></p>
                <p><span>Username: </span><input type="username" name="username" value="<?= $username ?>" /></p>
                <p><span>Password: </span><input type="password" name="password" value="<?= $password ?>" /></p>
                <p><span>Password: </span><input type="password" name="password" /></p>
                <p><button>Register</button></p>
            </form>
        </div>
    </div>
</body>

<script>
    function hideAddress(option) {
        console.log(option);
        if (option == "customer") {
            $('#address').show()
        } else {
            $('#address').hide()
        }
    }
</script>