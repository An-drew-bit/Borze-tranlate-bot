<?php

namespace config;

class Settings
{
    public function __construct(
        protected string $token = '?'
    )
    {  
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
