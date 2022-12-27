<?php

declare(strict_types=1);

namespace App\CQRS\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;

trait MessageBusExceptionTrait
{
    public function throwException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        throw $exception;
    }
}
