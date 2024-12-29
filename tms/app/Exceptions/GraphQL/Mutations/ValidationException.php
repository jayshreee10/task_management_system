<?php

namespace App\Exceptions\GraphQL\Mutations;

use Exception;

class ValidationException extends Exception
{
    protected $message;
    protected $errors;


    public function __construct($message = "Validation Error", $errors = [])
    {
        $this->message = $message;
        $this->errors = $errors;

        parent::__construct($message);
    }


    public function getErrors()
    {
        return $this->errors;
    }


    public function render($request)
    {
        return response()->json([
            'message' => $this->message,
            'errors' => $this->errors,
        ], 422);
    }
}
