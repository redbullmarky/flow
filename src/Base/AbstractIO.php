<?php

namespace Flow\Base;

/**
 * Represents an input/output datapoint
 */
abstract class AbstractIO extends AbstractDatapoint
{
    /**
     * Connections this datapoint is paired with
     *
     * @var array
     */
    protected array $connections = [];

    /**
     * Connect to another IO datapoint
     *
     * @param AbstractIO $other The datapoint to pair with
     * @param bool $reciprocate Whether to set the reverse connection
     */
    public function connect(AbstractIO $other, bool $reciprocate = true)
    {
        $this->connections[$other->getName()] = $other;
        if ($reciprocate) {
            $other->connect($this, false);
        }
    }
}
