<?php

namespace Flow\Base;

interface NodeInterface
{
    /**
     * Fetch a unique identifier for this node
     *
     * @return string
     */
    public function getIdentifier(): string;

    public function build(): void;
    public function execute(): void;

    public function addInput(Input $input): Input;
    public function getInput(string $name): Input;

    public function addOutput(Output $output): Output;
    public function getOutput(string $name): Output;

    public function addOption(Option $option): Option;
    public function getOption(string $name): Option;
}
