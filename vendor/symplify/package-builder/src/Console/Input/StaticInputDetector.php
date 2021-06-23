<?php

declare (strict_types=1);
namespace ECSPrefix20210623\Symplify\PackageBuilder\Console\Input;

use ECSPrefix20210623\Symfony\Component\Console\Input\ArgvInput;
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ECSPrefix20210623\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
