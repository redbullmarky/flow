<?php

namespace Flow;

use Flow\Base\AbstractNode;
use Flow\Base\FlowException;
use Throwable;

class Runner
{
    private array $nodes = [];

    public function load(string $filename): self
    {
        try {
            $definition = json_decode(file_get_contents($filename), true);
        } catch (Throwable $e) {
            throw new FlowException('Cannot open definition file ' . $filename);
        }

        $connections = [];

        // main nodes
        foreach ($definition['nodes'] as $nodeDefinition) {
            $class = '\\Flow\\Node\\' . $nodeDefinition['type'] . 'Node';
            $this->addNode(new $class($nodeDefinition['id']));
            if (!empty($nodeDefinition['connections'])) {
                $connections[$nodeDefinition['id']] = $nodeDefinition['connections'];
            }
        }

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

    public function addNode(AbstractNode $node): AbstractNode
    {
        return $this->nodes[$node->getIdentifier()] = $node;
    }

    public function getNode(string $identifier): AbstractNode
    {
        if (!isset($this->nodes[$identifier])) {
            throw new FlowException('No node with the identifier \'' . $identifier . '\'');
        }
        return $this->nodes[$identifier];
    }

    public function run(): void
    {
        foreach ($this->nodes as $node) {
            if (!$node->getInputs()) {
                $node->run();
            }
        }
    }
}
