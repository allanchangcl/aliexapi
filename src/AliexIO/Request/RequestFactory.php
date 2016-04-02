<?php

namespace AliexApi\Request;

use AliexApi\Configuration\ConfigurationInterface;

/**
 * A requestfactory which creates a new requestobjects depending on the class name you provide
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class RequestFactory
{

    private static $requestObjects = array();

    private function __construct()
    {
        // noop
    }

    private function __clone()
    {
        // noop
    }

    public static function createRequest(ConfigurationInterface $configuration)
    {
        $class = $configuration->getRequest();
        $factoryCallback = $configuration->getRequestFactory();

        if (true === is_object($class) && $class instanceof \AliexApi\Request\RequestInterface) {
            $class->setConfiguration($configuration);

            return self::applyCallback($factoryCallback, $class);
        }

        if (true === is_string($class) && true === array_key_exists($class, self::$requestObjects)) {
            $request = self::$requestObjects[$class];
            $request->setConfiguration($configuration);

            return self::applyCallback($factoryCallback, $request);
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException(sprintf("Requestclass not found: %s", $class));
        }

        if ($reflectionClass->implementsInterface('\\AliexApi\\Request\\RequestInterface')) {          
            $request = new $class();
            $request->setConfiguration($configuration);

            return self::$requestObjects[$class] = self::applyCallback($factoryCallback, $request);
        }

        throw new \LogicException(sprintf("Requestclass does not implements the RequestInterface: %s", $class));
    }

    protected static function applyCallback($callback, $request)
    {
        if (false === is_null($callback) && is_callable($callback)) {
            $request = call_user_func($callback, $request);
            if ($request instanceof RequestInterface) {
                return $request;
            }

            throw new \LogicException(
                sprintf(
                    "Requestclass does not implements the RequestInterface: %s",
                    get_class($request)
                )
            );
        }

        return $request;
    }
}