<?php

declare(strict_types=1);

namespace App\Check\Core;

class ReflectionResolver
{
    public function resolve(string $class): object
    {
        try {
            $reflectionClass = new \ReflectionClass($class);

            if (($constructor = $reflectionClass->getConstructor()) === null) {
                return $reflectionClass->newInstance();
            }

            if (($params = $constructor->getParameters()) === []) {
                return $reflectionClass->newInstance();
            }

            $newInstanceParams = [];
            foreach ($params as $param) {
                $newInstanceParams[] = $param->getType() === null ? $param->getDefaultValue() : $this->resolve(
                    $param->getType()->getName()
                );
            }

            return $reflectionClass->newInstanceArgs(
                $newInstanceParams
            );
        } catch (\ReflectionException $e) {
            throw new \ReflectionException('ReflectionException: ' . $e->getMessage());
        }
    }
}
