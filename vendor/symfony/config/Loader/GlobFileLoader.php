<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210512\Symfony\Component\Config\Loader;

/**
 * GlobFileLoader loads files from a glob pattern.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class GlobFileLoader extends \ECSPrefix20210512\Symfony\Component\Config\Loader\FileLoader
{
    /**
     * {@inheritdoc}
     * @param string|null $type
     */
    public function load($resource, $type = null)
    {
        return $this->import($resource);
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function supports($resource, $type = null)
    {
        return 'glob' === $type;
    }
}
