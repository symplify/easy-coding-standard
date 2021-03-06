<?php

declare (strict_types=1);
namespace ECSPrefix20210721\Symplify\ComposerJsonManipulator\Bundle;

use ECSPrefix20210721\Symfony\Component\HttpKernel\Bundle\Bundle;
use ECSPrefix20210721\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ECSPrefix20210721\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface|null
     */
    protected function createContainerExtension()
    {
        return new \ECSPrefix20210721\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
