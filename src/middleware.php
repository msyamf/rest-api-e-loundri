<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$app->add(new \Tuupola\Middleware\JwtAuthentication([
    "path" => "/api", /* or ["/api", "/admin"] */
    "attribute" => "token",
    "secret" => "supersecretkeyyoushouldnoittogithub",
    "algorithm" => ["HS256"],
    "error" => function ($response, $arguments) {
        $data["status"] = "unauthorized";
       // $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));