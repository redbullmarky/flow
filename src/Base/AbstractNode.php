<?php

namespace Flow\Base;

use Flow\Base\FlowException;
use Flow\Base\NodeInterface;

abstract class AbstractNode implements NodeInterface
{
    private string $identifier;
    private array $nextNodes = [];

    private array $inputData = [];
    private array $outputData = [];
    private array $optionData = [];

    /**
     * Create node with a unique identifier, custom or randomly generated.
     *
     * @param string|null $identifier
     */
    public function __construct(?string $identifier = null)
    {
        $this->identifier = $identifier ?? uniqid();
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(NodeInterface $node, array $wiring): void
    {
        if (!$node->getInputs()) {
            throw new FlowException('Cannot add an entry node beyond the root');
        }
        $this->nextNodes[$node->getIdentifier()] = [
            'node' => $node,
            'wiring' => $wiring
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getInputs(): ?array
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getOutputs(): ?array
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions(): ?array
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setOptionValue(string $key, $data): void
    {
        $this->optionData[$key] = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionValue(string $key)
    {
        return $this->optionData[$key] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function setInputValue(string $key, $data)
    {
        if (!$this->getInputs()) {
            throw new FlowException(get_class($this) . ' has no input \'' . $key . '\'');
        }
        $this->inputData[$key] = $data;

        if (!array_diff(array_keys($this->getInputs()), array_keys($this->inputData))) {
            $this->run();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getInputValue(string $key)
    {
        return $this->inputData[$key] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function setOutputValue(string $key, $value)
    {
        $this->outputData[$key] = $value; // not sure we need an array as opposed to just doing what run does and setting it directly on the next node...
    }

    /**
     * {@inheritDoc}
     */
    abstract public function execute(): void;

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        $this->execute();
        foreach ($this->nextNodes as $nextNode) {
            foreach ($this->outputData as $k => $v) {
                if (!empty($nextNode['wiring'][$k])) {
                    $nextNode['node']->setInputValue($nextNode['wiring'][$k], $v);
                }
            }
        }
    }
}

