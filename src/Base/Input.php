<?php

namespace Flow\Base;

class Input extends AbstractIO
{
    private $value;

    public function setValue($value)
    {
        $this->value = $value;

        // @fixme; doesn't seem like the job of the Input directly to do this...
        // for now, it works.
        if ($this->getHost()->canRun()) {
            $this->getHost()->run();
        }
    }

    public function hasValue(): bool
    {
        return isset($this->value);
    }

    public function getValue()
    {
        return $this->value ?? null;
    }
}
