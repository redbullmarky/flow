<?php

namespace Flow\Base;

class Output extends AbstractIO
{
    public function setValue($value)
    {
        foreach ($this->connections as $connection) {
            $connection->setValue($value);
        }
    }
}
