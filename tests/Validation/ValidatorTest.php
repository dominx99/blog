<?php

namespace dominx99\blog\Validation;

use PHPUnit\Framework\TestCase;
use Respect\Validation\Validator as v;
use dominx99\blog\Validation\Validator;

use Slim\Http\Environment;
use Slim\Http\Request;
use dominx99\blog\App;

class ValidatorTest extends TestCase {

    protected $params;
    protected $rules;

    public function setUp(){
        $this->params = [
            'email' => 'ddd@ddd.com',
            'name' => 'Dominik',
            'password' => 'haslo123'
        ];

        $this->rules = [
            'email' => v::notEmpty()->email(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::notEmpty()->length(6, 16)
        ];
    }

    public function testThatUserDataValidationWorks(){
        $validation = (new Validator)->validate($this->params, $this->rules);

        $this->assertTrue($validation->passes());
    }

    public function testThatRequestCanBeValidated(){
        $env = Environment::mock();
        $req = Request::createFromEnvironment($env)->withParsedBody($this->params);

        $validation = (new Validator)->validate($req, $this->rules);

        $this->assertTrue($validation->passes());
    }

    public function testThatErrorsAreSetAfterFailedValidation(){
        $params = [
            'email' => 'ddd.com',
            'name' => '  ',
            'password' => ''
        ];

        $validation = (new Validator)->validate($params, $this->rules);

        $errors = $validation->get();

        $this->assertCount(3, $errors);
        $this->assertCount(2, $errors['password']);
    }

}
