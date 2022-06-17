<?php

namespace Flow\Node;

class AdderNode extends AbstractNode
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

	public function execute(): void
	{
		$number1 = $this->getInputValue('number1');
		$number2 = $this->getInputValue('number2');
		$this->setOutputValue('result', $number1 + $number2);
	}
}
