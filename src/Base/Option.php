<?php

namespace Flow\Base;

class Option extends AbstractDatapoint
{
    private $value;

    public function __construct(AbstractNode $host, string $name, string $type = 'any', $default = null)
    {
        parent::__construct($host, $name, $type);
        $this->value = $default;
    }

    public function setValue($value)
    {
        $this->value = $value;

        // @fixme / @todo; notify of update?
    }

    public function hasValue(): bool
    {
        return isset($this->value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
