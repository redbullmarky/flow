<?php

namespace Flow;

use Exception;

class Runner
{
	/**
	 * Array of all root nodes
	 *
	 * @var NodeInterface[]
	 */
	private array $rootNodes = [];

	/**
	 * Set the entry node
	 *
	 * @param NodeInterface $node
	 * @return NodeInterface
	 */
	public function addNode(NodeInterface $node): NodeInterface
	{
		if ($node->getInputs()) {
			throw new Exception('Cannot add root node that requires input');
		}
		return $this->rootNodes[$node->getIdentifier()] = $node;
	}

	/**
	 * Run the flow, passing in optional array of inputs
	 *
	 * @return void
	 */
	public function run(): void
	{
		foreach ($this->rootNodes as $node) {
			$node->run();
		}
	}
}
