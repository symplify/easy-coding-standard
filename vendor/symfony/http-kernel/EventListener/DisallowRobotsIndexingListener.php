<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210508\Symfony\Component\HttpKernel\EventListener;

use ECSPrefix20210508\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ECSPrefix20210508\Symfony\Component\HttpKernel\Event\ResponseEvent;
use ECSPrefix20210508\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Ensures that the application is not indexed by search engines.
 *
 * @author Gary PEGEOT <garypegeot@gmail.com>
 */
class DisallowRobotsIndexingListener implements \ECSPrefix20210508\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    const HEADER_NAME = 'X-Robots-Tag';
    /**
     * @return void
     */
    public function onResponse(\ECSPrefix20210508\Symfony\Component\HttpKernel\Event\ResponseEvent $event)
    {
        if (!$event->getResponse()->headers->has(static::HEADER_NAME)) {
            $event->getResponse()->headers->set(static::HEADER_NAME, 'noindex');
        }
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [\ECSPrefix20210508\Symfony\Component\HttpKernel\KernelEvents::RESPONSE => ['onResponse', -255]];
    }
}