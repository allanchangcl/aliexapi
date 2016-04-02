<?php

namespace AliexApi\Configuration;

interface ConfigurationInterface
{

    public function getApiKey();

    public function getTrackingKey();

    public function getDigitalSign();

    public function getRequest();

    public function getRequestFactory();

    public function getResponseTransformer();

    // public function getResponseTransformerFactory();

}
