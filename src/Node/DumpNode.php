<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;

class DumpNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input('input'));
    }

    public function execute(): void
    {
    }
}
