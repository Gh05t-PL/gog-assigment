<?php

namespace App\DTO\Outcoming;

class ExceptionDTO implements OutcomingDTO
{
    private string $message;

    public function __construct(
        \Exception $exception
    ) {
        $this->message = $exception->getMessage();
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
