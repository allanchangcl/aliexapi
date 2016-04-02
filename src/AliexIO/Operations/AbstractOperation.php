<?php

namespace AliexApi\Operations;

abstract class AbstractOperation implements OperationInterface
{
    protected $parameter = array();

    public function getOperationParameter()
    {
        return $this->parameter;
    }

    public function __call($methodName, $parameter)
    {
        if (substr($methodName, 0, 3) == 'set') {
            $this->parameter[substr($methodName, 3)] = array_shift($parameter);

            return $this;
        }

        if (substr($methodName, 0, 3) == 'get') {
            $keyName = substr($methodName, 3);

            return isset($this->parameter[$keyName]) ? $this->parameter[$keyName] : null;
        }

        throw new \BadFunctionCallException(sprintf('The function "%s" does not exist!', $methodName));
    }
}
