<?php


namespace App\Contract;


interface TokenInterface
{
    public function authTokens($email,$password):string;
}
