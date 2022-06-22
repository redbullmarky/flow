<?php

namespace Flow\Base;

class Input extends AbstractIO
{
    public function setValue($value)
    {
        // should be set by previous nodes and, once all values for all plugged inputs set, execute the node
        throw new FlowException('input setval not implemented yet');
    }
}
