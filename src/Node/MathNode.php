<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\Input;
use Flow\Base\Option;
use Flow\Base\Output;

class MathNode extends AbstractNode
{
    public function build(): void
    {
        $this->addInput(new Input($this, 'number1', 'integer'));
        $this->addInput(new Input($this, 'number2', 'integer'));
        $this->addOutput(new Output($this, 'result', 'integer'));
        $this->addOption(new Option($this, 'operator', 'string'))->setValue('+');
    }

    public function run(): void
    {
        $in1 = $this->getInput('number1')->getValue();
        $in2 = $this->getInput('number2')->getValue();
        $op = $this->getOption('operator')->getValue();

        $result = null;
        $expression = sprintf("%d %.1s %d", $in1, $op, $in2);
        $code = "\$result = {$expression};";
        eval($code);
dump($expression);
        $this->getOutput('result')->setValue($result);
    }
}
