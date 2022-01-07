<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <meta charset="UTF-8" />
    <title>Login</title>
</head>

<body>
    <p><a href="home">Home</a></p>

    <h1>Login</h1>

    <div id="main">
        <div class="login-box">
            <form action="<?= BASE_URL . "login" ?>" method="post">
                <p><span>Username: </span><input type="username" name="username" value="<?= $username ?>" /></p>
                <p><span>Password: </span><input type="password" name="password" value="<?= $password ?>" /></p>
                <p><button>Login</button></p>
            </form>
        </div>
    </div>
</body>