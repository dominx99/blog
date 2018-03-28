<?php

namespace dominx99\school\Validation;

use PHPUnit\Framework\TestCase;
use Respect\Validation\Validator as v;
use dominx99\school\Validation\Validator;

use Slim\Http\Environment;
use Slim\Http\Request;

class ValidatorTest extends TestCase
{
    protected $rules;

    public function setUp()
    {
        $this->rules = [
            'email' => v::notEmpty()->email(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::notEmpty()->length(6, 16)
        ];
    }

    public function testThatRequestCanBeValidated()
    {
        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'Dominik',
            'password' => 'haslo123'
        ];

        $env = Environment::mock();
        $req = Request::createFromEnvironment($env)->withParsedBody($params);

        $validation = (new Validator)->validate($req, $this->rules);

        $this->assertTrue($validation->passes());
    }

    public function testThatErrorsAreSetAfterFailedValidation()
    {
        $params = [
            'email' => 'ddd.com',
            'name' => '  ',
            'password' => ''
        ];

        $env = Environment::mock();
        $req = Request::createFromEnvironment($env)->withParsedBody($params);

        $validation = (new Validator)->validate($req, $this->rules);

        $errors = $validation->get();

        $this->assertTrue($validation->failed());
        $this->assertCount(3, $errors);
        $this->assertCount(2, $errors['password']);
    }
}
