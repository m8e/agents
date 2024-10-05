<?php

// app/Agents/BaseAgent.php

namespace App\Agents\Messages;

use App\Contracts\MessageContract;
use Illuminate\Support\Carbon;

abstract class BaseMessage implements MessageContract
{

    public function __construct(
        private string $content,
        private ResponderTypeEnum $sender,
        private ResponderTypeEnum $recipient,
        protected Carbon $timestamp,
    )  {
    }
}
