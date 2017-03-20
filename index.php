<?php

    use Bigbookpl\UriParser\Parser\ParsedURI;
    use Bigbookpl\UriParser\SchemeResolver;

    require_once __DIR__.'/vendor/autoload.php';

    $config = ['settings' => [
        'addContentLengthHeader' => false,
    ]];

    $app = new \Slim\App($config);

    $app->post('/validate', function ($request, $response, $args) {

    $resolver = new SchemeResolver("http://www.onet.pl/hhhj/dfjhdsj?dhjdshd=jhds#jfhs");
    $validator = $resolver->getValidator();

    if ($validator->validate()) {

        $parsed = $resolver->getParser()->getParsed();

        return $response->withJSON( $parsed );
    }
    });

    $app->run();