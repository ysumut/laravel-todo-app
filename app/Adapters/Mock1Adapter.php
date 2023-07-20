<?php

namespace App\Adapters;

use App\Interfaces\ApiInterface;

class Mock1Adapter implements ApiInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getName()
    {
        return $this->data['id'];
    }

    public function getTime()
    {
        return $this->data['sure'];
    }

    public function getDifficulty()
    {
        return $this->data['zorluk'];
    }
}
