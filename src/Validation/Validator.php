<?php

namespace dominx99\blog\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    /**
     * @var array errors
     */
    protected $errors;

    /**
     * @param array $params params to validate
     * @param array $rules rules according to which params will be valited
     * @return object returns object of this class to easily check if validation psases
     */
    public function validate($params, $rules)
    {
        if($params instanceof \Slim\Http\Request) {
            $params = $params->getParams();
        }

        foreach($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($params[$field]);
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    /**
     * @return boolean true if validation passes
     */
    public function passes()
    {
        return empty($this->errors);
    }

    /**
     * @return boolean false if validation failed
     */
    public function failed()
    {
        return !empty($this->errors);
    }

    /**
     * @return array errors
     */
    public function get()
    {
        return $this->errors;
    }
}
