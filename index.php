<?php

use controller\ControllerHome;
use controller\ControllerLogin;
use controller\ControllerTest;
use controller\ControllerArtiste;
use route\Route;

require "classes/autoload.php";


$routes = [
    new Route("/", "GET", ControllerHome::class, "view", []),
    new Route("/add", "GET", ControllerHome::class, "add", ["t"]),
    new Route("/test", "GET", ControllerTest::class, "view"),
    new Route("/artiste", "GET", ControllerArtiste::class, "view")
];


$uri = parse_url($_SERVER["REQUEST_URI"]);
$method = $_SERVER["REQUEST_METHOD"];
$url = $uri["path"] ?? "/";
$role = $_SESSION["utilisateur"]["role"] ?? "user";

$notFound = true;

foreach($routes as $route){
    if(!($url === $route->getUrl()))continue;
    if(!($method === $route->getMethod()))continue;
    if(count($route->getRoles()) > 0 and !in_array($role, $route->getRoles()))continue;

    $controller = $route->getController();
    $action = $route->getAction();

    (new $controller())->$action();

    $notFound = false;

    break;
}

if($notFound){
    header("HTTP/1.0 404 Not Found");   
}