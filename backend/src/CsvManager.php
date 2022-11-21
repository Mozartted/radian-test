<?php

declare(strict_types=1);

namespace Radian;

use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use League\Csv\Reader;
use League\Csv\Writer;

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
    $reader = Reader::createFromPath(dirname(__DIR__).'/data.csv', 'r');
    $reader->setHeaderOffset(0);
    $data = [];
    $results = $reader->getRecords();
  // $results is an iterator
    // $data = [];
    foreach ($results as $row) {
    // each row will have the following data
          $data[] = $row;
    }
    $response->getBody()->write(json_encode($data));

    return $response;
  }

  public function updateItem(ServerRequest $request): ResponseInterface {
    $file_location = dirname(__DIR__).'/data.csv';
    $csv = Reader::createFromPath($file_location, 'r');
    $csv->setHeaderOffset(0);
    $data = [];
    $results = $csv->getRecords();
    foreach ($results as $row) {
          $data[] = $row;
    }
    $requestObject = (array) json_decode($request->getBody()->getContents());

    $key = array_search($requestObject["id"], array_column($data, 'id'));

    $data[$key] = $requestObject;

    $outFile = fopen($file_location, "w");
    fclose($outFile);
    // check data to find the array with the matching attribute.
    $writer = Writer::createFromPath($file_location, 'w');
    $csv->setHeaderOffset(0);
    // var_dump($data);
    // write to the csv file.
    $writer->insertOne([
      "id",
      "name",
      "state",
      "zip",
      "amount",
      "qty",
      "item"
    ]);

    foreach($data as $item){
      $writer->insertOne([
        (string) $item["id"],
        (string) $item["name"],
        (string) $item["state"],
        (string) $item["zip"],
        (string) $item["amount"],
        (string) $item["qty"],
        (string) $item["item"],
      ]);
    }

    // return response here 
    $this->response->getBody()->write(json_encode($requestObject));
    return $this->response;
  }

  public function addItem(ServerRequest $request): ResponseInterface {
    $file_location = dirname(__DIR__).'/data.csv';
    $csv = Reader::createFromPath($file_location, 'r');
    $data = [];
    $results = $csv->getRecords();
    foreach ($results as $row) {
          $data[] = $row;
    }
    $requestObject = (array) json_decode($request->getBody()->getContents());

    $array_keys = array_values($data[0]);
    // check data to find the array with the matching attribute.
    $writer = Writer::createFromPath($file_location, 'a');
    $writer->setNewline("\r\n");

    $newRecord = [];
    forEach($array_keys as $key){
      $newRecord[] = $requestObject[$key];
    }
    // var_dump($newRecord);
    $writer->insertOne($newRecord);
    // return response here 
    $this->response->getBody()->write(json_encode($requestObject));
    return $this->response;
  }

   public function deleteItem(ServerRequest $request): ResponseInterface {
    $file_location = dirname(__DIR__).'/data.csv';
    $id = $request->getAttribute("id");
    $csv = Reader::createFromPath($file_location, 'r');
    $csv->setHeaderOffset(0);
    $data = [];
    $results = $csv->getRecords();
    foreach ($results as $row) {
          $data[] = $row;
    }
    $requestObject = (array) json_decode($request->getBody()->getContents());

    $key = array_search($id, array_column($data, 'id'));

    unset($data[$key]);

    $outFile = fopen($file_location, "w");
    fclose($outFile);
    // check data to find the array with the matching attribute.
    $writer = Writer::createFromPath($file_location, 'w');
    $csv->setHeaderOffset(0);
    // var_dump($data);
    // write to the csv file.
    $writer->insertOne([
      "id",
      "name",
      "state",
      "zip",
      "amount",
      "qty",
      "item"
    ]);

    foreach($data as $item){
      $writer->insertOne([
        (string) $item["id"],
        (string) $item["name"],
        (string) $item["state"],
        (string) $item["zip"],
        (string) $item["amount"],
        (string) $item["qty"],
        (string) $item["item"],
      ]);
    }

    // return response here 
    $this->response->getBody()->write(json_encode($requestObject));
    return $this->response;
  }
}