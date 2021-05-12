<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210512\Symfony\Component\DependencyInjection\Exception;

/**
 * Thrown when trying to inject a parameter into a constructor/method with an incompatible type.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Julien Maulny <jmaulny@darkmira.fr>
 */
class InvalidParameterTypeException extends \ECSPrefix20210512\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
{
    /**
     * @param string $serviceId
     * @param string $type
     */
    public function __construct($serviceId, $type, \ReflectionParameter $parameter)
    {
        $serviceId = (string) $serviceId;
        $type = (string) $type;
        $acceptedType = $parameter->getType();
        $acceptedType = $acceptedType instanceof \ReflectionNamedType ? $acceptedType->getName() : (string) $acceptedType;
        $this->code = $type;
        $function = $parameter->getDeclaringFunction();
        $functionName = $function instanceof \ReflectionMethod ? \sprintf('%s::%s', $function->getDeclaringClass()->getName(), $function->getName()) : $function->getName();
        parent::__construct(\sprintf('Invalid definition for service "%s": argument %d of "%s()" accepts "%s", "%s" passed.', $serviceId, 1 + $parameter->getPosition(), $functionName, $acceptedType, $type));
    }
}
