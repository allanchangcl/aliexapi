<?php

namespace CLC\AliexApi;

class ResponseTransformerFactory
{

    private static $responseTransformerObjects = array();

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function createResponseTransformer(ConfigurationInterface $configuration)
    {
        $class = $configuration->getResponseTransformer();
        $factoryCallback = $configuration->getResponseTransformerFactory();

        if (true === is_object($class) && $class instanceof ResponseTransformerInterface) {
            return self::applyCallback($factoryCallback, $class);
        }

        if (true === is_string($class) && true === array_key_exists($class, self::$responseTransformerObjects)) {
            return self::applyCallback($factoryCallback, self::$responseTransformerObjects[$class]);
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException(sprintf("Responsetransformerclass not found: %s", $class));
        }

        if ($reflectionClass->implementsInterface('\\Clchang\\AliexApi\\ResponseTransformerInterface')) {
            $responseTransformer = new $class();

            return self::$responseTransformerObjects[$class] = self::applyCallback(
                $factoryCallback,
                $responseTransformer
            );
        }

        throw new \LogicException(
            sprintf(
                "Responsetransformerclass does not implements the ResponseTransformerInterface: %s",
                $class
            )
        );
    }

    protected static function applyCallback($callback, $responseTransformer)
    {
        if (false === is_null($callback) && is_callable($callback)) {
            $responseTransformer = call_user_func($callback, $responseTransformer);
            if ($responseTransformer instanceof ResponseTransformerInterface) {
                return $responseTransformer;
            }

            throw new \LogicException(
                sprintf(
                    "Responsetransformerclass does not implements the ResponseTransformerInterface: %s",
                    get_class($responseTransformer)
                )
            );
        }

        return $responseTransformer;
    }
}