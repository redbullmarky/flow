<?php

namespace Flow\Base;

abstract class AbstractIO
{
    private $connections = [];

    public function __construct(string $name, string $type = 'any')
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function connect(AbstractIO $other, bool $reciprocate = true)
    {
        $this->connections[$other->getName()] = $other;
        if ($reciprocate) {
            $other->connect($this, false);
        }
    }

    abstract public function setValue($value);
}
