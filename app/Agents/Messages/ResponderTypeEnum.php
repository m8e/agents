<?php

namespace App\Agents\Messages;

enum ResponderTypeEnum: string
{
    case USER = 'user';
    case LLM = 'llm';
    case AGENT = 'agent';
}
