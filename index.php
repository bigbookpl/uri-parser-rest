<?php

use Bigbookpl\UriParser\Parser\ParserException;
use Bigbookpl\UriParser\SchemeResolver;
use Bigbookpl\UriParser\Validator\ValidationException;

require_once __DIR__ . '/vendor/autoload.php';


$app = new \Slim\App();

$app->post('/parse', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $uri = $request->getParsedBodyParam('uri');

    if (!$uri) {
        return $response->withStatus(400)->write('URI not found');
    }

    $resolver = new SchemeResolver($uri);
    $validator = $resolver->getValidator();

    try {
        $validator->validate();
        $parsed = $resolver->getParser()->getParsed();

        return $response->withJson($parsed);

    } catch (ValidationException | ParserException $e) {
        return $response->withStatus(400)->write($e->getMessage());
    }

});

$app->run();