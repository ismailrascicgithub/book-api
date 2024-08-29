<?php
require_once __DIR__ . '/Response.php';

// KLASA KOJA OMOGUĆAVA DEFINISANJE RUTA I NJIHOVO RUKOVANJE
class Router
{
    private $routes = [];
    private $basePath = '/book-api';

    public function add($method, $route, $action, $middlewares = [])
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => rtrim($route, '/'),
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

    public function run()
    {
        $request_method = $_SERVER["REQUEST_METHOD"];
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (strpos($request_uri, $this->basePath) === 0) {
            $request_uri = substr($request_uri, strlen($this->basePath));
        }

        $request_uri = rtrim($request_uri, '/');

        foreach ($this->routes as $route) {
            if ($this->match($route, $request_method, $request_uri)) {
                $input = json_decode(file_get_contents("php://input"), true);
                $this->handle($route, $request_uri, $input);
                return;
            }
        }

        Response::send(404, ["message" => "Not Found"]);
    }

    private function match($route, $request_method, $request_uri)
    {
        if ($route['method'] !== $request_method) {
            return false;
        }

        $pattern = '#^' . preg_replace('/\{(\w+)\}/', '([^/]+)', $route['route']) . '$#';

        return preg_match($pattern, $request_uri);
    }

    private function handle($route, $request_uri, $input)
    {
        $pattern = '#^' . preg_replace('/\{(\w+)\}/', '([^/]+)', $route['route']) . '$#';
        preg_match($pattern, $request_uri, $matches);
        array_shift($matches);

        foreach ($route['middlewares'] as $middleware) {
            if (is_callable($middleware)) {
                call_user_func($middleware, $input);
            } elseif (is_string($middleware) && class_exists($middleware)) {
                $middleware_instance = new $middleware();
                
                if (is_string($route['action']) && strpos($route['action'], '@') !== false) {
                    list($controller, $method) = explode('@', $route['action']);
                    
                    if (class_exists($controller)) {
                        $middleware_instance->handle($input, new $controller());
                    } else {
                        $middleware_instance->handle($input, null);
                    }
                } else {
                    $middleware_instance->handle($input, null);
                }
            }
        }

        if (is_callable($route['action'])) {
            call_user_func_array($route['action'], array_merge($matches, [$input]));
        } elseif (is_string($route['action']) && strpos($route['action'], '@') !== false) {
            list($controller, $method) = explode('@', $route['action']);
            if (class_exists($controller)) {
                $controller_instance = new $controller();
                call_user_func_array([$controller_instance, $method], array_merge($matches, [$input]));
            }
        }
    }
}
