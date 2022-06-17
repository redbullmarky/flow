<?php

namespace Flow\Node;

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
