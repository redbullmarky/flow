<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;

class DumpNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input($this, 'input'));
    }

    public function run(): void
    {
        dump($this->getInput('input')->getValue());
    }
}
