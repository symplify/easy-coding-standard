<?php

declare (strict_types=1);
namespace ECSPrefix20210623\Symplify\PackageBuilder\Console\Command;

use ECSPrefix20210623\Symfony\Component\Console\Command\Command;
use ECSPrefix20210623\Symfony\Component\Console\Input\InputOption;
use ECSPrefix20210623\Symfony\Component\Console\Style\SymfonyStyle;
use ECSPrefix20210623\Symfony\Contracts\Service\Attribute\Required;
use ECSPrefix20210623\Symplify\PackageBuilder\ValueObject\Option;
use ECSPrefix20210623\Symplify\SmartFileSystem\FileSystemGuard;
use ECSPrefix20210623\Symplify\SmartFileSystem\Finder\SmartFinder;
use ECSPrefix20210623\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \ECSPrefix20210623\Symfony\Component\Console\Command\Command
{
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    protected $symfonyStyle;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    protected $smartFileSystem;
    /**
     * @var \Symplify\SmartFileSystem\Finder\SmartFinder
     */
    protected $smartFinder;
    /**
     * @var \Symplify\SmartFileSystem\FileSystemGuard
     */
    protected $fileSystemGuard;
    public function __construct()
    {
        parent::__construct();
        $this->addOption(\ECSPrefix20210623\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \ECSPrefix20210623\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @return void
     */
    #[Required]
    public function autowireAbstractSymplifyCommand(\ECSPrefix20210623\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ECSPrefix20210623\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ECSPrefix20210623\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \ECSPrefix20210623\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
