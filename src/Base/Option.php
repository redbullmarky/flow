<?php

namespace Flow\Base;

class Option extends AbstractDatapoint
{
    private bool $set = false;
    private $value;

    public function setValue($value)
    {
        $this->value = $value;
        $this->set = true;

        // @fixme / @todo; notify of update?
    }

    public function hasValue(): bool
    {
        return $this->set;
    }

    public function getValue()
    {
        return $this->value;
    }
}
