<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;

class MathNode extends AbstractNode
{
    public function getInputs(): array
    {
        return [
            'number1' => 'integer',
            'number2' => 'integer'
        ];
    }

    public function getOutputs(): array
    {
        return [
            'result' => 'integer'
        ];
    }

    public function getOptions(): array
    {
        return [
            'operator' => [] // todo sort the option settings out
        ];
    }

    public function execute(): void
    {
        $number1 = $this->getInputValue('number1');
        $number2 = $this->getInputValue('number2');
        $operator = $this->getOptionValue('operator');
        $result = null;

        $expression = "\$result = {$number1} {$operator} {$number2};";
        eval($expression);
        $this->setOutputValue('result', $result);
    }
}
