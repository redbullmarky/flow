<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;
use Flow\Base\Output;

class CodeNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input($this, 'foo'));
        $this->addOutput(new Output($this, 'bar'));
    }

    public function run(): void
    {
        $this->getOutput('bar')->setValue('i am code output! input was ' . $this->getInput('foo')->getValue());
    }
}
