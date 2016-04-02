<?php

namespace AliexApi\Configuration;

class GenericConfiguration implements ConfigurationInterface
{

    protected $apiKey;

    protected $trackingKey;

    protected $digitalSign;

    protected $request = '\AliexApi\Request\Rest\Request';
    
    protected $requestFactory = null;

    protected $responseTransformer = null;

    protected $responseTransformerFactory = null;

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getTrackingKey()
    {
        return $this->trackingKey;
    }

    public function setTrackingKey($trackingKey)
    {
        $this->trackingKey = $trackingKey;

        return $this;
    }

    public function getDigitalSign()
    {
        return $this->digitalSign;
    }

    public function setDigitalSign($digitalSign)
    {
        $this->digitalSign = $digitalSign;

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    public function getRequestFactory()
    {
        return $this->requestFactory;
    }

    public function setRequestFactory($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("Given argument is not callable");
        }

        $this->requestFactory = $callback;

        return $this;
    }

    public function getResponseTransformer()
    {
        return $this->responseTransformer;
    }

    public function setResponseTransformer($responseTransformer)
    {
        $this->responseTransformer = $responseTransformer;

        return $this;
    }

    public function getResponseTransformerFactory()
    {
        return $this->responseTransformerFactory;
    }

    public function setResponseTransformerFactory($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("Given argument is not callable");
        }

        $this->responseTransformerFactory = $callback;

        return $this;
    }


}
