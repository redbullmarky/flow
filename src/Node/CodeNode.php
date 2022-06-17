<?php

namespace Flow\Node;

use Flow\FlowException;
use Flow\NodeInterface;
use V8Js;
use V8JsScriptException;

class FlowJs extends V8Js
{
	private $host;

	public function __construct(NodeInterface $host, string $namespace)
	{
		parent::__construct($namespace);
		$this->host = $host;
	}

	public function getInputValue($key) {
		return $this->host->getInputValue($key);
	}

	public function setOutputValue($key, $value) {
		$this->host->setOutputValue($key, $value);
	}
}

class CodeNode extends AbstractNode
{
	private $v8js;
	private $instance;

	private function getCodeInstance()
	{
		if (!$this->instance) {
			$this->v8js = new FlowJs($this, 'flow');

			try {
				$this->instance = $this->v8js->executeString('(() => { ' . $this->getCode() . ' })();');
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
		flow.setOutputValue('bar', 'up the titties!');
	}
}
EOF;
	}
}
