<?php

declare(strict_types=1);

namespace App\CQRS\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function ask(QueryInterface $query, array $stamps = []): mixed
    {
        try {
            $envelope = $this->bus->dispatch(new Envelope($query, $stamps));
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
