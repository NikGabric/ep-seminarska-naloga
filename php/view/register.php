<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Register</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>

<body>
    <p><a href="home">Home</a></p>

    <h1>Register</h1>

    <div id="main">
        <div class="register-box">
            <form action="<?= BASE_URL . "register" ?>" method="post">
                <p>
                    <span>Account role:</span>
                    <select name="role" onchange="hideAddress(this.value)">
                        <option value="salesman" selected>Seller</option>
                        <option value="customer">Customer</option>
                    </select>
                </p>
                <p><span>Name: </span><input type="name" name="name" value="<?= $name ?>" autofocus /></p>
                <p><span>Surname: </span><input type="name" name="surname" value="<?= $surname ?>" /></p>
                <p id="address" hidden><span>Address: </span><input type="text" name="address" value="<?= $address ?>" /></p>
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
        if (option == "customer") {
            $('#address').show()
        } else {
            $('#address').hide()
        }
    }
</script>