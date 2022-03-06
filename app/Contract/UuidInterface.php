<?php


namespace App\Contract;


interface UuidInterface
{

    public function setUuid(string $uuid);
    public function getUuid():string;

}
