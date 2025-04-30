<?php declare(strict_types=1);

class Router
{
  private array $routes = [];

  public function add(string $path, Closure $handler): void
  {
    $this->routes[$path] = $handler;
  }

  public function dispatch(string $path): void
  {
    if (array_key_exists($path, $this->routes)) {
      $handler = $this->routes[$path];
      call_user_func($handler);
    } else {
      http_response_code(404);
      echo '404 Not Found';
    }
  }
}
