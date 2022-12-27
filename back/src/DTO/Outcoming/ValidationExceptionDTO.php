<?php

namespace App\DTO\Outcoming;

class ValidationExceptionDTO implements OutcomingDTO
{
    private string $message;
    private array $violations;

    public function __construct(
        array $violations
    ) {
        $this->message = 'Invalid data sent.';
        $this->violations = $violations;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
