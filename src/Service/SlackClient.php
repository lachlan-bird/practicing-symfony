<?php

namespace App\Service;


use App\Helper\Loggable;
use Nexy\Slack\Client;

class SlackClient
{
    use Loggable;

    private $slack;

    public function __construct(Client $slack)
    {

        $this->slack = $slack;
    }

    public function sendMessage(string $from, string $message)
    {
        $this->logInfo('Testing from trait!', [
            'message' => $message
        ]);

        $this->slack->sendMessage($this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message)
        );
    }
}