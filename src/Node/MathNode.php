<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;
use Flow\Base\Output;

class MathNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input('number1', 'integer'));
        $this->addInput(new Input('number2', 'integer'));
        $this->addOutput(new Output('result', 'integer'));
    }

    public function execute(): void
    {
    }
}
