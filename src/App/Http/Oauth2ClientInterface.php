<?php


namespace App\Http;


use Psr\Http\Message\ResponseInterface;

interface Oauth2ClientInterface
{
    public function get(string $endpoint) : ResponseInterface;
    public function delete(string $endpoint) : ResponseInterface;
    public function token() : ResponseInterface;
}