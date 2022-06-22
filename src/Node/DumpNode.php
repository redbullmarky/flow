<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;

class DumpNode extends AbstractNode
{
    public function getInputs(): array
    {
        return [
            'input' => 'any'
        ];
    }

    public function execute(): void
    {
        dump($this->getInputValue('input'));
    }
}
