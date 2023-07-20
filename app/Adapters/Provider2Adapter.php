<?php

namespace App\Adapters;

use App\Interfaces\ApiInterface;

class Provider2Adapter implements ApiInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getName()
    {
        return array_key_first($this->data);
    }

    public function getTime()
    {
        return array_values($this->data)[0]['estimated_duration'];
    }

    public function getDifficulty()
    {
        return array_values($this->data)[0]['level'];
    }
}
