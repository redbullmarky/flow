<?php

namespace Flow\Base;

abstract class AbstractIO
{
    protected AbstractNode $host;
    protected string $name;
    protected string $type;
    protected array $connections = [];

    public function __construct(AbstractNode $host, string $name, string $type = 'any')
    {
        $this->host = $host;
        $this->name = $name;
        $this->type = $type;
    }

    public function getHost(): AbstractNode
    {
        return $this->host;
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
