<?php

use controller\ControllerAlbum;
use controller\ControllerHome;
use controller\ControllerLogin;
use controller\ControllerArtiste;
use controller\ControllerPublier;
use controller\ControllerPubliePlaylist;
use controller\ControllerCategory;
use controller\ControllerAdmin;
use controller\ControllerPlaylist;
use controller\ControllerHeader;
use models\Musique;
use route\Route;
use utils\Utils;

require "classes/autoload.php";

session_start();
$routes = [
    new Route("/", "GET", ControllerHome::class, "view", []),
    new Route("/search", "POST", ControllerHeader::class, "search", []),
    new Route("/getPlaylistSub", "GET", ControllerHome::class, "view", []),
    new Route("/publiersSonsPlaylist", "POST", ControllerHome::class, "publiersSonsPlaylist", []),
    new Route("/artiste", "GET", ControllerArtiste::class, "view", [], ["id"]),
    new Route("/follow", "POST", ControllerArtiste::class, "follow", []),
    new Route("/album", "GET", ControllerAlbum::class, "view", [], ["id"]),
    new Route("/publier", "GET", ControllerPublier::class, "view", ["user", "artiste", "admin"]),
    new Route("/publier", "POST", ControllerPublier::class, "publierContenue", []),
    new Route("/publierPlaylist", "POST", ControllerPubliePlaylist::class, "publierPlaylist", []),
    new Route("/effacerPlaylist", "POST", ControllerPubliePlaylist::class, "effacerPlaylist", []),
    new Route("/categorie", "GET", ControllerCategory::class, "view", [], ["category"]),
    new Route("/filtreView", "GET", ControllerCategory::class, "filtreView", [], ["year", "category", "genre", "artistId"]),
    new Route("/login", "POST", ControllerLogin::class),
    new Route("/login", "GET", ControllerLogin::class),
    new Route("/album", "POST", ControllerAlbum::class),
    new Route("/administrateur", "GET", ControllerAdmin::class, "view", ["admin"], []),
    new Route("/administrateur", "POST", ControllerAdmin::class, "supprimer", [], []),
    new Route("/playlist/musique", "POST", ControllerPlaylist::class, null, [], ["musique", "playlist"]),
    new Route("/playlist", "GET", ControllerPlaylist::class, "view", [], ["id"]),
    new Route("/playlist/edit", "POST", ControllerPlaylist::class, "ajaxUpdatePlaylist", [], ["id", "titre", "description"]),
    // new Route("/getMusiquesAlbumSelec", "GET", ControllerHome::class, "view", [], []),
        // new Route("/getPlaylistItem/id", "GET", ControllerPubliePlaylist::class, "getPlaylistItem", [], ["id"]),
];


$uri = parse_url($_SERVER["REQUEST_URI"]);
$method = $_SERVER["REQUEST_METHOD"];
$url = $uri["path"] ?? "/";
$role = !is_null(Utils::getConnexion()) ? Utils::getConnexion()->getRoleU() : "logout";
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