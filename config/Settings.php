<?php

namespace config;

class Settings
{
    protected $token;

    public function __construct()
    {
        $this->token = '?';
    }

    public function getToken()
    {
        return $this->token;
    }
}