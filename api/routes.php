<?php

require_once __DIR__ . '/controllers/book/BookController.php';
require_once __DIR__ . '/controllers/auth/AuthController.php';
require_once __DIR__ . '/middlewares/auth/AuthenticateMiddleware.php';
require_once __DIR__ . '/middlewares/ValidationMiddleware.php';

$router->add('GET', '/api/books', 'BookController@getBooks');
$router->add('GET', '/api/books/{id}', 'BookController@getBook');
$router->add('POST', '/api/books', 'BookController@addBook', [ValidationMiddleware::class, AuthenticateMiddleware::class]);
$router->add('PUT', '/api/books/{id}', 'BookController@updateBook', [ValidationMiddleware::class, AuthenticateMiddleware::class]);
$router->add('DELETE', '/api/books/{id}', 'BookController@deleteBook', [AuthenticateMiddleware::class]);

$router->add('POST', '/api/auth/token', 'AuthController@getToken');
