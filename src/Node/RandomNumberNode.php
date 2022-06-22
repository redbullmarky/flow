<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Output;

class RandomNumberNode extends AbstractNode
{
    public function build(): void
    {
        $this->addOutput(new Output($this, 'number', 'integer'));
    }

    public function run(): void
    {
        $this->getOutput('number')->setValue(rand(0, 1000));
    }
}
