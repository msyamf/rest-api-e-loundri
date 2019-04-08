<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;
// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post('/login', function (Request $request, Response $response, array $args) {
    $input = $request->getParsedBody();
    $sql = "SELECT * FROM users WHERE email= :email";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("email", $input['email']);
    $sth->execute();
    $user = $sth->fetchObject();
    // verify email address.
    if(!$user) {
        return $this->response->withJson(['status'=>'fail','error' => true, 'message' => 'These credentials do not match our records.']);  
    }
 
    // verify password.
    if (!password_verify($input['password'],$user->password)) {
        return $this->response->withJson(['status'=>'fail','error' => true, 'message' => 'These credentials do not match our records.']);  
    }
 
    $settings = $this->get('settings'); // get settings array.
    
    $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $settings['jwt']['secret'], "HS256");
 
    return $this->response->withJson(['status'=>'success','error' => false,'token' => $token]);
 
});

$app->group('/api', function(\Slim\App $app) {
 
    $app->get('/user',function(Request $request, Response $response, array $args) {
       $data = $request->getAttribute('token');
       $response->withStatus(401);
        return $this->response->withJson(['status'=>'sucess','data_user' => $data]);

    });
   
});