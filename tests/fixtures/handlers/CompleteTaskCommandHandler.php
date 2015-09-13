<?php

namespace cherif\tactician\tests\fixtures\handlers;

use cherif\tactician\tests\fixtures\container\Mailer;

class CompleteTaskCommandHandler
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handleCompleteTaskCommand($command)
    {
    	return 'foobar';
    }
}
