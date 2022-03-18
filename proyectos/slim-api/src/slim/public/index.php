<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../config/database.php';


$app = new \Slim\App;


$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    

    return $response;
});

$app->get('/books/', 'get_books');
$app->get('/books/{id}', function($request, $response, $args) {
    get_book_id($args['id']);
});


$app->run();

function get_books() {
    $pdo = connect_db();
    $statement=$pdo->prepare("SELECT * FROM books;");
    $statement->execute();

    if (!$statement){
        echo 'Error al ejecutar la consulta';
    }else{
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    }
    $pdo = NULL;
}

function get_book_id($id) {
    $pdo = connect_db();
    $statement=$pdo->prepare("SELECT * FROM books WHERE id ='$id';");
    $statement->execute();

    if (!$statement){
        echo 'Error al ejecutar la consulta';
    }else{
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    }
    $pdo = NULL;
}


