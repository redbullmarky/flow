<?php

namespace Flow;

use Flow\Base\AbstractNode;
use Flow\Base\FlowException;
use Throwable;

/**
 * Main setup/entry point for the Flow
 */
class Runner
{
    /**
     * @var AbstractNode[]
     */
    private array $nodes = [];

    /**
     * Load from definition file
     *
     * @param string $filename
     * @return Runner self
     */
    public function load(string $filename): self
    {
        try {
            $definition = json_decode(file_get_contents($filename), true);
        } catch (Throwable $e) {
            throw new FlowException('Cannot open definition file ' . $filename);
        }

        $connections = [];

        // main nodes & options
        foreach ($definition['nodes'] as $nodeDefinition) {
            $class = '\\Flow\\Node\\' . $nodeDefinition['type'] . 'Node';
            $node = $this->addNode(new $class($nodeDefinition['id']));
            if (!empty($nodeDefinition['connections'])) {
                $connections[$nodeDefinition['id']] = $nodeDefinition['connections'];
            }
            if (!empty($nodeDefinition['options'])) {
                foreach ($nodeDefinition['options'] as $optName => $optVal) {
                    $node->getOption($optName)->setValue($optVal);
                }
            }
        }

        // connections
        foreach ($connections as $from => $to) {
            $fromNode = $this->getNode($from);
            foreach ($to as $map) {
                $toNode = $this->getNode($map['node']);

                list ($fromOutputId, $toInputId) = explode(':', $map['map']);
                $fromOutput = $fromNode->getOutput($fromOutputId);
                $toInput = $toNode->getInput($toInputId);

                $fromOutput->connect($toInput);
            }
        }

        return $this;
    }

    /**
     * Add a new node to the Flow
     *
     * @param AbstractNode $node
     * @param bool $replace Whether to replace a node of the same name, if already set
     * @return AbstractNode The added node
     */
    public function addNode(AbstractNode $node, bool $replace = false): AbstractNode
    {
        if (!$replace && !empty($this->nodes[$node->getIdentifier()])) {
            throw new FlowException('Node with identifer \'' . $node->getIdentifier() . '\' already exists');
        }
        return $this->nodes[$node->getIdentifier()] = $node;
    }

    /**
     * Fetch a node by identifier
     *
     * @param string $identifier
     * @return AbstractNode
     */
    public function getNode(string $identifier): AbstractNode
    {
        if (!isset($this->nodes[$identifier])) {
            throw new FlowException('No node with the identifier \'' . $identifier . '\'');
        }
        return $this->nodes[$identifier];
    }

    /**
     * Execute the flow. Loops all nodes with no inputs available
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->nodes as $node) {
            if (!$node->getInputs()) {
                $node->run();
            }
        }
    }
}
