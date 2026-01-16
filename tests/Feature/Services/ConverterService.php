<?php

use App\Services\ConverterService;

beforeEach(function () {
    $this->service = new ConverterService;
});

it('can convert a basic python dict', function () {
    $dict = "{'key': 'value', 'number': 42}";
    $json = $this->service->convertPythonToJson($dict, pretty: false);
    $this->assertJson($json);

    $expected = '{"key":"value","number":42}';
    $this->assertEquals($expected, $json);
});

it('can convert tuples', function () {
    $dict = "{'key': (1, 2), 'number': 42}";
    $json = $this->service->convertPythonToJson($dict, pretty: false);
    $this->assertJson($json);

    $expected = '{"key":[1,2],"number":42}';
    $this->assertEquals($expected, $json);
});

it('throws error when tuples are keys', function () {
    $dict = "{(1, 2): (3, 4), 'number': 42}";
    $this->service->convertPythonToJson($dict, pretty: false);
})->throws(App\Exceptions\JsonConversionException::class);

it('throws error when invalid dict passed', function () {
    $dict = "{(1, 2): (3, 4), 'number'";
    $this->service->convertPythonToJson($dict, pretty: false);
})->throws(App\Exceptions\InvalidDictException::class);

it('rejects code injection attempts', function () {
    $dict = "__import__('os').system('rm -rf /temp')";
    $this->service->convertPythonToJson($dict);
})->throws(App\Exceptions\InvalidDictException::class);

it('converts nested dicts', function () {
    $dict = "{'a': {'b': {'c': 1}}}";
    $json = $this->service->convertPythonToJson($dict, pretty: false);
    $this->assertEquals('{"a":{"b":{"c":1}}}', $json);
});

it('converts lists', function () {
    $dict = "{'items': [1, 2, 3]}";
    $json = $this->service->convertPythonToJson($dict, pretty: false);
    $this->assertEquals('{"items":[1,2,3]}', $json);
});

it('converts booleans', function () {
    $dict = "{'flag': True, 'other': False}";
    $json = $this->service->convertPythonToJson($dict, pretty: false);
    $this->assertEquals('{"flag":true,"other":false}', $json);
});

it('converts None to null', function () {
    $dict = "{'value': None}";
    $json = $this->service->convertPythonToJson($dict, pretty: false);
    $this->assertEquals('{"value":null}', $json);
});

it('throws on unsupported types like sets', function () {
    $dict = "{'items': {1, 2, 3}}";
    $this->service->convertPythonToJson($dict);
})->throws(App\Exceptions\JsonConversionException::class);

it('throws on invalid escape sequences', function () {
    $dict = "{'key': '\\xZZ'}";
    $this->service->convertPythonToJson($dict);
})->throws(App\Exceptions\InvalidDictException::class);

it('converts empty dict', function () {
    $dict = '{}';
    $json = $this->service->convertPythonToJson($dict);
    $this->assertEquals('{}', $json);
});

it('converts empty array', function () {
    $dict = '[]';
    $json = $this->service->convertPythonToJson($dict);
    $this->assertEquals('[]', $json);
});
