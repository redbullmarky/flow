<?php

namespace Flow\Base;

use Flow\Base\FlowException;
use Flow\Base\Input;
use Flow\Base\Option;
use Flow\Base\Output;

abstract class AbstractNode implements NodeInterface
{
    private string $identifier;
    private ?array $inputs = null;
    private ?array $outputs = null;
    private ?array $options = null;

    public function __construct(string $identifier = null)
    {
        $this->identifier = $identifier ?? uniqid();
        $this->build();
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    abstract public function build(): void;

    abstract public function execute(): void;

    public function addInput(Input $input): Input
    {
        return $this->inputs[$input->getName()] = $input;
    }

    public function getInput(string $name): Input
    {
        if (!$this->inputs || !isset($this->inputs[$name])) {
            throw new FlowException('No input for node ' . $this->getIdentifier() . ': ' . $name);
        }
        return $this->inputs[$name];
    }

    public function addOutput(Output $output): Output
    {
        return $this->outputs[$output->getName()] = $output;

    }

    public function getOutput(string $name): Output
    {
        if (!$this->outputs || !isset($this->outputs[$name])) {
            throw new FlowException('No output for node ' . $this->getIdentifier() . ': ' . $name);
        }
        return $this->outputs[$name];
    }

    public function addOption(Option $option): Option
    {
        return $this->options[$option->getName()] = $option;

    }

    public function getOption(string $name): Option
    {
        if (!$this->options || !isset($this->options[$name])) {
            throw new FlowException('No option for node ' . $this->getIdentifier() . ': ' . $name);
        }
        return $this->options[$name];
    }
}
