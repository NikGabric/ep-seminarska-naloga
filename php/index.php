<?php

// enables sessions for the entire app
session_start();

require_once("controller/CubesController.php");
require_once("controller/UsersController.php");
require_once("controller/StoreController.php");

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
        $_SESSION["loggedin"] = false;
        ViewHelper::redirect(BASE_URL . "store");
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
            UsersController::editUsername($_SESSION["id"]);
        } else {
            print("else");
        }
    },
    "/^account\/(\d+)\/editPassword$/" => function ($method) {
        if ($method == "POST") {
            UsersController::editPassword($_SESSION["id"]);
        } else {
            print("else");
        }
    },
    "/^store\/addToCart$/" => function ($method) {
        StoreController::addToCart();
    },
    "/^store\/updateCart$/" => function ($method) {
        StoreController::updateCart();
    },
    "/^store\/finishOrder$/" => function ($method) {
        StoreController::finishOrder();
    },
    "/^store\/purgeCart$/" => function ($method) {
        StoreController::purgeCart();
    },
    "/^home$/" => function ($method) {
        ViewHelper::redirect(BASE_URL . "store");
    }
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
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
