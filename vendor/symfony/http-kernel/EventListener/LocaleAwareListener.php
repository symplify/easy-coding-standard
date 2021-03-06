<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210721\Symfony\Component\HttpKernel\EventListener;

use ECSPrefix20210721\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ECSPrefix20210721\Symfony\Component\HttpFoundation\RequestStack;
use ECSPrefix20210721\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use ECSPrefix20210721\Symfony\Component\HttpKernel\Event\RequestEvent;
use ECSPrefix20210721\Symfony\Component\HttpKernel\KernelEvents;
use ECSPrefix20210721\Symfony\Contracts\Translation\LocaleAwareInterface;
/**
 * Pass the current locale to the provided services.
 *
 * @author Pierre Bobiet <pierrebobiet@gmail.com>
 */
class LocaleAwareListener implements \ECSPrefix20210721\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $localeAwareServices;
    private $requestStack;
    /**
     * @param LocaleAwareInterface[] $localeAwareServices
     */
    public function __construct($localeAwareServices, \ECSPrefix20210721\Symfony\Component\HttpFoundation\RequestStack $requestStack)
    {
        $this->localeAwareServices = $localeAwareServices;
        $this->requestStack = $requestStack;
    }
    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     * @return void
     */
    public function onKernelRequest($event)
    {
        $this->setLocale($event->getRequest()->getLocale(), $event->getRequest()->getDefaultLocale());
    }
    /**
     * @param \Symfony\Component\HttpKernel\Event\FinishRequestEvent $event
     * @return void
     */
    public function onKernelFinishRequest($event)
    {
        if (null === ($parentRequest = $this->requestStack->getParentRequest())) {
            foreach ($this->localeAwareServices as $service) {
                $service->setLocale($event->getRequest()->getDefaultLocale());
            }
            return;
        }
        $this->setLocale($parentRequest->getLocale(), $parentRequest->getDefaultLocale());
    }
    public static function getSubscribedEvents()
    {
        return [
            // must be registered after the Locale listener
            \ECSPrefix20210721\Symfony\Component\HttpKernel\KernelEvents::REQUEST => [['onKernelRequest', 15]],
            \ECSPrefix20210721\Symfony\Component\HttpKernel\KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', -15]],
        ];
    }
    /**
     * @return void
     */
    private function setLocale(string $locale, string $defaultLocale)
    {
        foreach ($this->localeAwareServices as $service) {
            try {
                $service->setLocale($locale);
            } catch (\InvalidArgumentException $e) {
                $service->setLocale($defaultLocale);
            }
        }
    }
}
