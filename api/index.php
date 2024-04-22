<?php
require __DIR__ . '/vendor/autoload.php';

require 'rb.php';
R::setup('mysql:host=localhost;dbname=dbname', 'user', 'pass');

$router = new \Bramus\Router\Router();

$router->options('.*', function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    exit();
});

$router->get('/', function () {

    $users = R::find('users');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    echo json_encode(r::exportAll($users));
});

$router->post('/users', function () {
    $data = json_decode(file_get_contents('php://input'), true);

    $user = R::dispense('users');
    $user->name = $data['name'];
    $user->lastname = $data['lastname'];
    $user->email = $data['email'];

    $id = R::store($user);

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    echo json_encode(['id' => $id]);
});

$router->run();
