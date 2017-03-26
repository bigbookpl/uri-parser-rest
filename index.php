<?php

use Bigbookpl\UriParser\Parser\ParserException;
use Bigbookpl\UriParser\Parser\Strategy\GenericParser;
use Bigbookpl\UriParser\Parser\Strategy\URNParser;
use Bigbookpl\UriParser\ParserSet;
use Bigbookpl\UriParser\SchemeResolver;
use Bigbookpl\UriParser\Validator\Strategy\EmailValidator;
use Bigbookpl\UriParser\Validator\Strategy\GenericValidator;
use Bigbookpl\UriParser\Validator\Strategy\URNValidator;
use Bigbookpl\UriParser\Validator\ValidationException;
use Bigbookpl\UriParser\ValidatorSet;

require_once __DIR__ . '/vendor/autoload.php';


$app = new \Slim\App();

$app->post('/parse', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $uri = $request->getParsedBodyParam('uri');

    if (!$uri) {
        return $response->withStatus(400)->write('URI not found');
    }

    $validatorSet = new ValidatorSet();
    $validatorSet->addValidator(new GenericValidator());
    $validatorSet->addValidator(new EmailValidator());
    $validatorSet->addValidator(new URNValidator());

    $parserSet = new ParserSet();
    $parserSet->addParser(new GenericParser());
    $parserSet->addParser(new URNParser());

    $resolver = new SchemeResolver($uri, $validatorSet, $parserSet);
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