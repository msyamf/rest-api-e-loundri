<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$app->add(new \Tuupola\Middleware\JwtAuthentication([
    "path" => ["/transaksi","/pengguna","/ticket","/m-harga"], /* or ["/api", "/admin"] */
    "secure" => false,
    "attribute" => "token",
    "secret" => "supersecretkeyyoushouldnoittogithub",
    "algorithm" => ["HS256"],
    "error" => function ($response, $arguments) {
        $data["status"] = "unauthorized";
        $data["proses"] = false;
       // $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            
    }
]));

$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ['Authorization','Content-Type'],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));