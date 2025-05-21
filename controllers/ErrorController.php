<?php
class ErrorController {
    public static function notFound() {
        http_response_code(404);
        include 'views/errors/error.php';
    }
}
