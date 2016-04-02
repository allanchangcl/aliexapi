<?php

namespace AliexApi;

use AliexApi\Configuration\ConfigurationInterface;
use AliexApi\Operations\OperationInterface;
use AliexApi\Request\RequestFactory;
use AliexApi\ResponseTransformer\ResponseTransformerFactory;

class AliexIO
{
    const VERSION = "1.0.0-DEV";
    protected $configuration;

    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->configuration = $configuration;
    }

    public function runOperation(OperationInterface $operation, ConfigurationInterface $configuration = null)
    {
        $configuration = is_null($configuration) ? $this->configuration : $configuration;

        if (true === is_null($configuration)) {
            throw new \Exception('No configuration passed.');
        }

        $requestObject = RequestFactory::createRequest($configuration);
        
        $response = $requestObject->perform($operation);

        return $this->applyResponseTransformer($response, $configuration);

    }

    protected function applyResponseTransformer($response, ConfigurationInterface $configuration)
    {
        if (true === is_null($configuration->getResponseTransformer())) {
            return $response;
        }

        $responseTransformer = ResponseTransformerFactory::createResponseTransformer($configuration);
        
        return $responseTransformer->transform($response);
    }
}