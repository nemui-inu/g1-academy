<?php declare(strict_types=1);

class Router
{
  private static array $routes = [];

  public static function add(string $path, Closure $handler): void
  {
    self::$routes[$path] = $handler;
  }

  public static function dispatch(string $path): void
  {
    if (array_key_exists($path, self::$routes)) {
      $handler = self::$routes[$path];
      call_user_func($handler);
    } else {
      http_response_code(404);
      echo '404 Not Found';
    }
  }
}
