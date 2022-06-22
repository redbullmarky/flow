<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\FlowException;

// todo; would probably need support for an input node to have multiple connections first, so as not to get messy.
// so if a node passes its data into the iterator, you could loopback to the same input. maybe. maybe it won't be as bad when it can be easier visualised...

class LoopNode extends AbstractNode
{
    public function getInputs(): array
    {
        return [
            'input' => 'any',
            'iterations' => 'integer'
        ];
    }

    public function getOutputs(): array
    {
        return [
            'loopack' => 'any', // data comes out here when there are still iterations left
            'output' => 'any' // data comes out here when it's all done
        ];
    }

    public function execute(): void
    {
        throw new FlowException('LoopNode not yet done');
    }
}
