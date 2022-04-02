<?php
const PROJECT_ROOT_PATH = __DIR__;
require_once PROJECT_ROOT_PATH . "/Model/Products.php";
require PROJECT_ROOT_PATH . "/Controller/Api/ProductsController.php";


    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    if ((isset($uri[1]) && $uri[1] == 'products')) {

        $productsController = new ProductsController();
        $productsController->listProducts();
    }
    else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }