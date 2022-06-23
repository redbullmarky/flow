<?php

namespace Flow\Node;

use Flow\Base\AbstractNode;
use Flow\Base\FlowException;
use Flow\Base\Input;
use Flow\Base\Option;
use Flow\Base\Output;
use FlowJS\FlowJS;
use V8JsScriptException;

/**
 * Example of having the node settings, logic, etc inside of JS
 * Could allow extensions by end-users to create their own nodes
 */
class CodeNode extends AbstractNode
{
    private $v8js;
    private $instance;

    public function build(): void
    {
        $instance = $this->getCodeInstance();
        if (method_exists($instance, 'getInputs') && ($inputs = $instance->getInputs())) {
            foreach ($inputs as $name => $type) {
                $this->addInput(new Input($this, $name, $type));
            }
        }
        if (method_exists($instance, 'getOutputs') && ($outputs = $instance->getOutputs())) {
            foreach ($outputs as $name => $type) {
                $this->addOutput(new Output($this, $name, $type));
            }
        }
        if (method_exists($instance, 'getOptions') && ($options = $instance->getOptions())) {
            foreach ($options as $name => $type) {
                $this->addOption(new Option($this, $name, $type));
            }
        }
    }

    public function run(): void
    {
        $this->getCodeInstance()->run();
    }

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

    run: () => {
        node.getOutput('bar').setValue('up the titties! `foo` was: ' + JSON.stringify(node.getInput('foo').getValue()));
    }
}
EOF;
    }
}
