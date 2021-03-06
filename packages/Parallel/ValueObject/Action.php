<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Parallel\ValueObject;

/**
 * @enum
 */
final class Action
{
    /**
     * @var string
     */
    const QUIT = 'quit';
    /**
     * @var string
     */
    const CHECK = 'check';
}
