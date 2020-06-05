<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->post('/login', function (Request $request, Response $response, array $args) {

        $input = $request->getParsedBody();
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject();

        // verify email address.
        if (!$user) {
            return $this->response->withJson(['error' => true, 'message' => 'Usuario o contraseña incorrecta.']);
        }

        // verify password.
        if (!password_verify($input['password'], $user->password)) {
            return $this->response->withJson(['error' => true, 'message' => 'Usuario o contraseña incorrecta.']);
        }

        $settings = $this->get('settings'); // get settings array.

        $token = JWT::encode(['id' => intval($user->id), 'email' => $user->email], $settings['jwt']['secret'], "HS256");

        return $this->response->withJson(['error' => false, 'token' => $token]);
    });

    $app->group('/api', function (\Slim\App $app) {

        // ? Obtener datos del token
        // $app->get('/user', function (Request $request, Response $response, array $args) {
        //     print_r($request->getAttribute('token_data'));
        // });
    });
};
