<?php

declare (strict_types=1);
namespace ECSPrefix20210703\Symplify\PackageBuilder\Console\Style;

use ECSPrefix20210703\Symfony\Component\Console\Application;
use ECSPrefix20210703\Symfony\Component\Console\Input\ArgvInput;
use ECSPrefix20210703\Symfony\Component\Console\Output\ConsoleOutput;
use ECSPrefix20210703\Symfony\Component\Console\Output\OutputInterface;
use ECSPrefix20210703\Symfony\Component\Console\Style\SymfonyStyle;
use ECSPrefix20210703\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment;
use ECSPrefix20210703\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class SymfonyStyleFactory
{
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesCaller
     */
    private $privatesCaller;
    public function __construct()
    {
        $this->privatesCaller = new \ECSPrefix20210703\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function create() : \ECSPrefix20210703\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \ECSPrefix20210703\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \ECSPrefix20210703\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \ECSPrefix20210703\Symfony\Component\Console\Application(), 'configureIO', [$argvInput, $consoleOutput]);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\ECSPrefix20210703\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\ECSPrefix20210703\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\ECSPrefix20210703\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \ECSPrefix20210703\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
