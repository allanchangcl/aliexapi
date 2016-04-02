<?php

namespace AliexApi\Operations;

interface OperationInterface
{

    public function getName();

    // public function setResponseGroup(array $responseGroup);

    public function getOperationParameter();
}
