<?php

session_start();

require_once "core/Database.php";
require_once "core/Router.php";

require_once "app/controllers/AuthController.php";
require_once "app/controllers/LogoutController.php";
require_once "app/controllers/VideoController.php";

require_once "app/models/CommentModel.php";
require_once "app/models/LikeModel.php";
require_once "app/models/UserModel.php";
require_once "app/models/VideoModel.php";

require_once "app/services/AuthService.php";
require_once "app/services/CommentService.php";
require_once "app/services/VideoService.php";

$config = require "config/Config.php";
$db = new Database($config);
$router = new Router($config);

$router->get('/', function() use ($db) {
    $videoModel = new VideoModel($db);
    $videos = $videoModel->getAllVideos();

    require "views/index.php";
});

$router->get('/video/:id', function($id) use ($db) {
    $videoModel = new VideoModel($db);
    $video = $videoModel->getVideoById($id);

    require "views/video/index.php";
});

$router->get('/login', function() {
    require "views/auth/login.php";
});

$router->post('/login', function() use ($db) {
    $controller = new AuthController($db);
    $controller->login();
});

$router->get('/register', function() {
    require "views/auth/register.php";
});

$router->post('/register', function() use ($db) {
    $controller = new AuthController($db);
    $controller->register();
});

$router->get('/dashboard', function() {
    require "views/dashboard/index.php";
});

$router->get('/dashboard/video/edit/:id', function($id) use ($db) {
    $videoModel = new VideoModel($db);
    $video = $videoModel->getVideoById($id);

    require "views/dashboard/video/edit.php";
});

$router->get('/dashboard/video/upload', function() {
    require "views/dashboard/video/upload.php";
});

$router->post('/dashboard/video/upload', function() use ($db) {
    $controller = new VideoController($db);
    $controller->uploadVideo();

    require_once "app/controllers/VideoController.php";
});

$router->get('/dashboard/video/delete/:id', function($id) use ($db) {
    $controller = new VideoController($db);
    $controller->deleteVideo($id);
});

$router->get('/logout', function() {
    $controller = new LogoutController();
    $controller->logout();
});

$router->resolve();