<?php

use Slim\App;

return function (App $app) {

    $app->add(new \Tuupola\Middleware\JwtAuthentication([
        "path" => "/api", /* or ["/api", "/admin"] */
        "header" => "X-API-KEY",
        "attribute" => "token_data",
        "secret" => "tvWCFkfwzPWy7iBCHQEvBZCZ7Q6Z1gNpHdmH17r8wN3SXccESWtd7PeWKZIUl2i6HNV0tq8087zxBq",
        "algorithm" => ["HS256"],
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]));
};
