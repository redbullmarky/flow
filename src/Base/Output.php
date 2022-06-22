<?php

namespace Flow\Base;

class Output extends AbstractIO
{
    public function setValue($value)
    {
        // should pass the value on to the inputs of connected nodes
        throw new FlowException('output setval not implemented yet');
    }
}
