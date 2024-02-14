<?php

use controller\ControllerAlbum;
use controller\ControllerHome;
use controller\ControllerLogin;
use controller\ControllerTest;
use controller\ControllerArtiste;
use controller\ControllerPublier;
use controller\ControllerPubliePlaylist;
use models\Musique;
use route\Route;

require "classes/autoload.php";

session_start();

$routes = [
    new Route("/", "GET", ControllerHome::class, "view", []),
    new Route("/getPlaylistSub", "GET", ControllerHome::class, "view", []),
    new Route("/publiersSonsPlaylist", "POST", ControllerHome::class, "view", []),
    // new Route("/getMusiquesAlbumSelec", "GET", ControllerHome::class, "view", [], []),
    new Route("/test", "GET", ControllerTest::class, "view"),
    new Route("/artiste", "GET", ControllerArtiste::class, "view", [], ["id"]),
    new Route("/album", "GET", ControllerAlbum::class, "view", [], ["id"]),
    new Route("/publier", "GET", ControllerPublier::class, "view", []),
    new Route("/publier", "POST", ControllerPublier::class, "publierContenue", []),
    new Route("/publierPlaylist", "POST", ControllerPubliePlaylist::class, "publierPlaylist", []),
    // new Route("/getPlaylistItem/id", "GET", ControllerPubliePlaylist::class, "getPlaylistItem", [], ["id"]),
    new Route("/login", "POST", ControllerLogin::class),
    new Route("/login", "GET", ControllerLogin::class),
];


$uri = parse_url($_SERVER["REQUEST_URI"]);
$method = $_SERVER["REQUEST_METHOD"];
$url = $uri["path"] ?? "/";
$role = $_SESSION["utilisateur"]["role"] ?? "user";
$params = $_REQUEST;
$action = $_REQUEST["action"] ?? null;

$notFound = true;

foreach($routes as $route){
    if(!($url === $route->getUrl()))continue;
    if(!($method === $route->getMethod()))continue;
    if(count($route->getRoles()) > 0 and !in_array($role, $route->getRoles()))continue;
    if(is_null($route->getAction()) and is_null($action))continue;

    $p = false;
    foreach($route->getParams() as $param){
        if(!isset($params[$param])){
            $p = true;
        }
    }
    if($p)continue;

    $controller = $route->getController();
    $actionRoute = $route->getAction();

    if(is_null($actionRoute)){
        (new $controller($params))->$action();
    }else{
        (new $controller($params))->$actionRoute();
    }

    $notFound = false;

    break;
}

if($notFound){
    header("HTTP/1.0 404 Not Found");   
}