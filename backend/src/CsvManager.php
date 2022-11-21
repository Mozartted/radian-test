<?php

declare(strict_types=1);

namespace Radian;

use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;

class CsvManager {
  private $response;

  public function __construct(ResponseInterface $response)
  {
    $this->response = $response;
  }

  public function __invoke(): ResponseInterface {
    $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write('<html><head></head><body>Go to the <a href="/hello">Hello, World!</a> example.</body></html>');

        return $response;
  }

  public function getItems(): ResponseInterface {
    $response = $this->response->withHeader('Content-Type', 'text/json');
    // var_dump("reached here");
    $response->getBody()->write(json_encode(["item"=>'1']));

    return $response;
  }

  public function updateItem(ServerRequest $request): ResponseInterface {
    // var_dump($request->getAttribute('id'));
    var_dump($request->getHeaders(),
            $request->getParsedBody(),
            $request->getQueryParams(),
            $request->getUploadedFiles(),
            $request->getBody()->getContents());

    return $this->response;
  }


}