<?php


namespace App\Service;


use App\Contract\UuidInterface;
use Illuminate\Support\Str;
use Redis;

class Uuid implements UuidInterface
{

    protected $uuid;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    public function handle()
    {
        $uuid = $this->redis->get('uuid');
        if(!$uuid)
        {
            $uuid = Str::uuid();
            $this->redis->set("uuid",$uuid);
        }
        $this->setUuid($uuid);
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
       return $this->uuid;
    }
}
