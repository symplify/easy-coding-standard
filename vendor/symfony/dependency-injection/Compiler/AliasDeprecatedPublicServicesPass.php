<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210508\Symfony\Component\DependencyInjection\Compiler;

use ECSPrefix20210508\Symfony\Component\DependencyInjection\ContainerBuilder;
use ECSPrefix20210508\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use ECSPrefix20210508\Symfony\Component\DependencyInjection\Reference;
final class AliasDeprecatedPublicServicesPass extends \ECSPrefix20210508\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    private $tagName;
    private $aliases = [];
    /**
     * @param string $tagName
     */
    public function __construct($tagName = 'container.private')
    {
        $tagName = (string) $tagName;
        $this->tagName = $tagName;
    }
    /**
     * {@inheritdoc}
     * @param bool $isRoot
     */
    protected function processValue($value, $isRoot = \false)
    {
        $isRoot = (bool) $isRoot;
        if ($value instanceof \ECSPrefix20210508\Symfony\Component\DependencyInjection\Reference && isset($this->aliases[$id = (string) $value])) {
            return new \ECSPrefix20210508\Symfony\Component\DependencyInjection\Reference($this->aliases[$id], $value->getInvalidBehavior());
        }
        return parent::processValue($value, $isRoot);
    }
    /**
     * {@inheritdoc}
     */
    public function process(\ECSPrefix20210508\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds($this->tagName) as $id => $tags) {
            if (null === ($package = isset($tags[0]['package']) ? $tags[0]['package'] : null)) {
                throw new \ECSPrefix20210508\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('The "package" attribute is mandatory for the "%s" tag on the "%s" service.', $this->tagName, $id));
            }
            if (null === ($version = isset($tags[0]['version']) ? $tags[0]['version'] : null)) {
                throw new \ECSPrefix20210508\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('The "version" attribute is mandatory for the "%s" tag on the "%s" service.', $this->tagName, $id));
            }
            $definition = $container->getDefinition($id);
            if (!$definition->isPublic() || $definition->isPrivate()) {
                continue;
            }
            $container->setAlias($id, $aliasId = '.' . $this->tagName . '.' . $id)->setPublic(\true)->setDeprecated($package, $version, 'Accessing the "%alias_id%" service directly from the container is deprecated, use dependency injection instead.');
            $container->setDefinition($aliasId, $definition);
            $this->aliases[$id] = $aliasId;
        }
        parent::process($container);
    }
}