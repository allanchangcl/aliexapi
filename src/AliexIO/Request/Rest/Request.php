<?php

namespace AliexApi\Request\Rest;

use AliexApi\Request\RequestInterface;
use AliexApi\AliexIO;
use AliexApi\Configuration\ConfigurationInterface;
use AliexApi\Operations\OperationInterface;

class Request implements RequestInterface
{

    const CONNECTION_TIMEOUT = CURLOPT_CONNECTTIMEOUT;
    const TIMEOUT = CURLOPT_TIMEOUT;
    const FOLLOW_LOCATION = CURLOPT_FOLLOWLOCATION;
    const USERAGENT = CURLOPT_USERAGENT;

    private $options = array();
    protected $requestScheme = 'http://gw.api.alibaba.com/openapi/param2/2/portals.open/%s';

    protected $configuration;

    public function __construct(array $options = array())
    {
        $this->options = array(
            self::USERAGENT          => "AliexIO [" . AliexIO::VERSION . "]",
            self::CONNECTION_TIMEOUT => 10,
            self::TIMEOUT            => 10,
            self::FOLLOW_LOCATION    => 1
        );
        $this->setOptions($options);
    }

    public function setOptions(array $options = array())
    {
        foreach ($options as $currentOption => $currentOptionValue) {
            $this->options[$currentOption] = $currentOptionValue;
        }
        $this->options[CURLOPT_RETURNTRANSFER] = 1; // force the return transfer
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function perform(OperationInterface $operation)
    {
        $ch = curl_init();

        if (false === $ch) {
            throw new \RuntimeException("Cannot initialize curl resource");
        }

        $preparedRequestParams = $this->prepareRequestParams($operation);
        
        $queryString = $this->buildQueryString($preparedRequestParams);
        
        $options = $this->options;

        $options[CURLOPT_URL] = sprintf($this->requestScheme, $queryString);

        foreach ($options as $currentOption => $currentOptionValue) {
            if (false === curl_setopt($ch, $currentOption, $currentOptionValue)) {
                throw new \RuntimeException(
                    sprintf(
                        "An error occurred while setting %s with value %s",
                        $currentOption,
                        $currentOptionValue
                    )
                );
            }
        }

        $curlError = false;
        $errorNumber = null;
        $errorMessage = null;

        $result = curl_exec($ch);

        if (false === $result) {
            $curlError = true;
            $errorNumber = curl_errno($ch);
            $errorMessage = curl_error($ch);
        }

        curl_close($ch);

        if ($curlError) {
            throw new \RuntimeException(
                sprintf(
                    "An error occurred while sending request. Error number: %d; Error message: %s",
                    $errorNumber,
                    $errorMessage
                )
            );
        }
        
        return $result;
    }

    protected function prepareRequestParams(OperationInterface $operation)
    {
        $baseRequestParams = array(
            'ApiKey' => $this->configuration->getApiKey(),
            'Operation' => $operation->getName(),
        );

        $operationParams = $operation->getOperationParameter();

        foreach ($operationParams as $key => $value) {
            if (true === is_array($value)) {
                $operationParams[$key] = implode(',', $value);
            }
        }

        $fullParameterList = array_merge($baseRequestParams, $operationParams);
        // ksort($fullParameterList);

        return $fullParameterList;
    }

    protected function buildQueryString(array $params)
    {
        $parameterList = array();

        $baseQueryString = sprintf('api.%s/%s?', $params['Operation'], $params['ApiKey']);
        $params = array_slice($params,2);

        foreach ($params as $key => $value) {
            $parameterList[] = sprintf('%s=%s', $key, rawurlencode($value));
        }

        return $baseQueryString . implode("&", $parameterList);
    }

}
