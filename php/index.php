<?php

// enables sessions for the entire app
session_start();

require_once("controller/CubesController.php");
require_once("controller/UsersController.php");
require_once("controller/StoreController.php");
require_once("controller/CubesRESTController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// ROUTER: defines mapping between URLS and controllers
$urls = [
    "/^store$/" => function () {
        CubesController::index();
    },
    "/^login$/" => function ($method) {
        if ($method == "POST") {
            UsersController::login();
        } else {
            UsersController::loginForm();
        }
    },
    "/^logout$/" => function () {
        UsersController::logout();
    },
    "/^register$/" => function ($method) {
        if ($method == "POST") {
            UsersController::register();
        } else {
            UsersController::registerForm();
        }
    },
    "/^account\/(\d+)$/" => function ($method) {
        UsersController::accountDashboard();
    },
    "/^account\/(\d+)\/editUsername$/" => function ($method) {
        if ($method == "POST") {
            UsersController::editUsername($_SESSION["user_id"]);
        } else {
            print("else");
        }
    },
    "/^account\/(\d+)\/editPassword$/" => function ($method) {
        if ($method == "POST") {
            UsersController::editPassword($_SESSION["user_id"]);
        } else {
            print("else");
        }
    },
    "/^account\/adminPanel$/" => function ($method) {
        if ($method == "POST") {
            UsersController::editPassword($_SESSION["user_id"]);
        } else {
            UsersController::adminPanelForm();
        }
    },
    "/^account\/adminPanel\/createNewUser$/" => function ($method) {
        UsersController::createNewUser();
    },
    "/^account\/(\d+)\/updateStatus$/" => function ($method) {
        UsersController::accountUpdateStatus();
    },
    "/^store\/addToCart$/" => function ($method) {
        StoreController::addToCart();
    },
    "/^store\/updateCart$/" => function ($method) {
        StoreController::updateCart();
    },
    "/^store\/finishOrder$/" => function ($method) {
        if ($method == "POST") {
            StoreController::finishOrder();
        } else {
            StoreController::finishOrderForm();
        }
    },
    "/^store\/viewCustomerOrders$/" => function ($method) {
        if ($method == "POST") {
        } else {
            UsersController::customerOrdersForm($_SESSION["user_id"]);
        }
    },
    "/^store\/finishedOrders$/" => function ($method) {
        if ($method == "POST") {
            StoreController::updateOrderStatus();
        } else {
            StoreController::finishedOrdersForm();
        }
    },
    "/^store\/addItem$/" => function ($method) {
        if ($method == "POST") {
            StoreController::addItem();
        } else {
            StoreController::addItemForm();
        }
    },
    "/^store\/purgeCart$/" => function ($method) {
        StoreController::purgeCart();
    },
    "/^home$/" => function ($method) {
        ViewHelper::redirect(BASE_URL . "store");
    },
    "/^$/" => function ($method) {
        ViewHelper::redirect(BASE_URL . "store");
    },
    // https://localhost/ep/php/api/cubes
    "/^api\/cubes$/" => function ($method) {
        switch ($method) {
            case "GET":
                CubesRESTController::index();
        }
    },
    // https://localhost/ep/php/api/cubes
    "/^api\/cubes\/(\d+)$/" => function ($method, $id) {
        switch ($method) {
            case "GET":
                CubesRESTController::get($id);
        }
    }
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            ViewHelper::error404();
        } catch (Exception $e) {
            ViewHelper::displayError($e, true);
        }

        exit();
    }
}

ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);
