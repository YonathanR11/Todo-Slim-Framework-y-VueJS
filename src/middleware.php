<?php

use Slim\App;

return function (App $app) {

    $app->add(new \Tuupola\Middleware\JwtAuthentication([
        "path" => "/api", /* or ["/api", "/admin"] */
        "header" => "X-API-KEY",
        "attribute" => "token_data",
        "secret" => "b863b3e53ce9b3d3c12d6bbbe5c7ee27dba833386ca055b5ec177c1a685c8cf5",
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
