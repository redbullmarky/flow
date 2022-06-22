<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Output;

class RandomNumberNode extends AbstractNode
{
    public function build(): void
    {
        $this->addOutput(new Output('number', 'integer'));
    }

    public function execute(): void
    {
    }
}
