<?php

namespace Flow\Base;

use Flow\Base\FlowException;
use Flow\Base\Input;
use Flow\Base\Option;
use Flow\Base\Output;

/**
 * Represents a general node
 */
abstract class AbstractNode
{
    /**
     * Unique identifier for this node
     *
     * @var string
     */
    private string $identifier;

    /**
     * Input datapoints this node has
     *
     * @var array|null
     */
    private ?array $inputs = null;

    /**
     * Output datapoints this node has
     *
     * @var array|null
     */
    private ?array $outputs = null;

    /**
     * Option datapoints this node has
     *
     * @var array|null
     */
    private ?array $options = null;

    /**
     * Create node with optional custom identifier and initialise its setup
     * If an identifier isn't passed, it'll be generated via uniqid()
     *
     * @param string $identifier
     */
    public function __construct(string $identifier = null)
    {
        $this->identifier = $identifier ?? uniqid();
        $this->build();
    }

    /**
     * Fetch the identifier for this node
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Setup this node with its inputs, outputs, options, etc
     *
     * @return void
     */
    abstract public function build(): void;

    /**
     * Execute the main node work
     *
     * @return void
     */
    abstract public function run(): void;

    /**
     * Add an input datapoint to this node
     *
     * @param Input $input
     * @return Input
     */
    public function addInput(Input $input): Input
    {
        return $this->inputs[$input->getName()] = $input;
    }

    /**
     * Get an input by name
     *
     * @param string $name
     * @return Input
     */
    public function getInput(string $name): Input
    {
        if (!$this->inputs || !isset($this->inputs[$name])) {
            throw new FlowException('No input for node ' . $this->getIdentifier() . ': ' . $name);
        }
        return $this->inputs[$name];
    }

    /**
     * Fetch all inouts
     *
     * @return array|null Inputs, or null of none are available
     */
    public function getInputs(): ?array
    {
        return $this->inputs;
    }

    /**
     * Add an output datapoint to this node
     *
     * @param Output $output
     * @return Output
     */
    public function addOutput(Output $output): Output
    {
        return $this->outputs[$output->getName()] = $output;
    }

    /**
     * Get an output by name
     *
     * @param string $name
     * @return Output
     */
    public function getOutput(string $name): Output
    {
        if (!$this->outputs || !isset($this->outputs[$name])) {
            throw new FlowException('No output for node ' . $this->getIdentifier() . ': ' . $name);
        }
        return $this->outputs[$name];
    }

    /**
     * Fetch all outputs
     *
     * @return array|null Outputs, or null of none are available
     */
    public function getOuputs(): ?array
    {
        return $this->outputs;
    }

    /**
     * Add an option datapoint to this node
     *
     * @param Option $option
     * @return Option
     */
    public function addOption(Option $option): Option
    {
        return $this->options[$option->getName()] = $option;

    }

    /**
     * Get an option by name
     *
     * @param string $name
     * @return Option
     */
    public function getOption(string $name): Option
    {
        if (!$this->options || !isset($this->options[$name])) {
            throw new FlowException('No option for node ' . $this->getIdentifier() . ': ' . $name);
        }
        return $this->options[$name];
    }

    /**
     * Fetch all options
     *
     * @return array|null Options, or null of none are available
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * Make sure this node has all inputs required to run; typically invoked after input values are updated
     *
     * @return bool
     */
    public function canRun(): bool
    {
        foreach ($this->getInputs() as $input) {
            if (!$input->hasValue()) {
                return false;
            }
        }
        return true;
    }
}
