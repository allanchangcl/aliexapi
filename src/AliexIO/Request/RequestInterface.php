<?php

namespace AliexApi\Request;

use AliexApi\Configuration\ConfigurationInterface;
use AliexApi\Operations\OperationInterface;

interface RequestInterface
{
    /**
     * Sets the configurationobject
     *
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration);

    /**
     * Performs the request
     *
     * @param OperationInterface $operation
     *
     * @return mixed The response of the request
     */
    public function perform(OperationInterface $operation);
}
