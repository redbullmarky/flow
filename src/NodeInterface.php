<?php

namespace Flow;

/**
 * Represents all nodes in a flow
 */
interface NodeInterface
{
    /**
     * Fetch the unique identifier for this node
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Add a followon node
     *
     * @param NodeInterface $node
     * @param array $wiring The mapping between outputs and inputs.
     *
     * @return void
     */
    public function connect(NodeInterface $node, array $wiring): void;

    /**
     * Fetch the inputs this node has; a key/val array of name => type.
     * If null is returned, this is a root-node only
     *
     * @return array|null
     */
    public function getInputs(): ?array;

    /**
     * Fetch the outputs this node has; a key/val array of name => type
     * If null is returned, this is a terminal node only
     *
     * @return array
     */
    public function getOutputs(): ?array;

    /**
     * Fetch the options this node has; options are configurable programatically allowing the same node type to operate differently
     *
     * @return array|null
     */
    public function getOptions(): ?array;

    /**
     * Sets the value for an option
     *
     * @param string $key
     * @param mixed $data
     * @return void
     */
    public function setOptionValue(string $key, $data): void;

    /**
     * Get the value for an option
     *
     * @param string $key
     * @return mixed
     */
    public function getOptionValue(string $key);

    /**
     * Set input for node and, when all wired inputs are provided, execute the node, setting inputs for next nodes if applicable
     * Should only be called by previous nodes
     *
     * @param string $key The input to set
     * @param mixed THe data
     */
    public function setInputValue(string $key, $data);

    /**
     * Fetch the input value set by previous node
     *
     * @param string $key
     * @return mixed
     */
    public function getInputValue(string $key);

    /**
     * Sets an output value of the current node; in turn, this sets the input of connected nodes
     *
     * @param string $key
     * @param mixed $value
     */
    public function setOutputValue(string $key, $value);

    /**
     * Execute the node
     *
     * @return void
     */
    public function execute(): void;

    /**
     * Called on the entry node to start the process
     *
     * @return void
     */
    public function run(): void;
}
