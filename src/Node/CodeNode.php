<?php

namespace Flow\Node;

use FlowJS\FlowJS;
use Flow\FlowException;
use V8JsScriptException;

class CodeNode extends AbstractNode
{
	private $v8js;
	private $instance;

	private function getCodeInstance()
	{
		if (!$this->instance) {
			$this->v8js = new FlowJS('flow');
            $this->v8js->node = $this;

			try {
				$setup = $this->v8js->executeString('((node) => { ' . $this->getCode() . ' });');
                $this->instance = $setup($this);
            } catch (V8JsScriptException $e) {
				throw new FlowException('Error in the code');
			}
		}
		return $this->instance;
	}

	public function getInputs(): array
	{
		return (array)$this->getCodeInstance()->getInputs();
	}

	public function getOutputs(): array
	{
		return (array)$this->getCodeInstance()->getOutputs();

	}

	public function execute(): void
	{
		$this->getCodeInstance()->execute();
	}

	private function getCode() {
		return <<<EOF
return {

	getInputs: () => {
		return {
			foo: 'any'
		}
	},

	getOutputs: () => {
		return {
			bar: 'any'
		}
	},

	execute: () => {
		node.setOutputValue('bar', 'up the titties!');
	}
}
EOF;
	}
}
