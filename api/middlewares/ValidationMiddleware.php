<?php

require_once __DIR__ . '/../controllers/book/BookController.php';
require_once __DIR__ . '/book/BookValidationMiddleware.php';
class ValidationMiddleware
{
    public function handle($input, $controller)
    {
        if ($controller instanceof BookController) {
            $middleware = new BookValidationMiddleware();
        } else {
            $middleware = null;
        }

        if ($middleware) {
            $middleware->handle($input);
        }
    }
}