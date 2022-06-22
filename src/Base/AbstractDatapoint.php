<?php

namespace Flow\Base;

/**
 * Represents part of node that handles data; inout, output or option
 */
abstract class AbstractDatapoint
{
    /**
     * The host node this datapoint belongs to
     *
     * @var AbstractNode
     */
    protected AbstractNode $host;

    /**
     * Datapoint's name
     *
     * @var string
     */
    protected string $name;

    /**
     * Datapoint's datatype
     *
     * @var string
     */
    protected string $type;

    /**
     * Create the datapoint for host, with a unique name (per host) and datatype
     *
     * @param AbstractNode $node Node this datapoint belongs to
     * @param string $name Datapoint name
     * @param string $type Datapoint datatype (e.g. string, integer, etc)
     */
    public function __construct(AbstractNode $host, string $name, string $type = 'any')
    {
        $this->host = $host;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Fetch the host this datapoint is attached to
     *
     * @return AbstractNode
     */
    public function getHost(): AbstractNode
    {
        return $this->host;
    }

    /**
     * Fetch the datapoint's name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Fetch the datapoint's datatype
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value for this datapoint
     * Typically handled differently based on whether it's an input, output or option
     *
     * @param mixed $value
     */
    abstract public function setValue($value);
}
