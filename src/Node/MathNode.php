<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;
use Flow\Base\Output;

class MathNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input($this, 'number1', 'integer'));
        $this->addInput(new Input($this, 'number2', 'integer'));
        $this->addOutput(new Output($this, 'result', 'integer'));
    }

    public function run(): void
    {
        $in1 = $this->getInput('number1')->getValue();
        $in2 = $this->getInput('number2')->getValue();
        $this->getOutput('result')->setValue($in1 + $in2);
    }
}
