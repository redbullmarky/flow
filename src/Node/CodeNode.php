<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;
use Flow\Base\Output;

class CodeNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input('foo'));
        $this->addOutput(new Output('bar'));
    }

    public function execute(): void
    {
    }
}
