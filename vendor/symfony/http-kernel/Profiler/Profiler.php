<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210608\Symfony\Component\HttpKernel\Profiler;

use ECSPrefix20210608\Psr\Log\LoggerInterface;
use ECSPrefix20210608\Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException;
use ECSPrefix20210608\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210608\Symfony\Component\HttpFoundation\Response;
use ECSPrefix20210608\Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use ECSPrefix20210608\Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
use ECSPrefix20210608\Symfony\Contracts\Service\ResetInterface;
/**
 * Profiler.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Profiler implements \ECSPrefix20210608\Symfony\Contracts\Service\ResetInterface
{
    private $storage;
    /**
     * @var DataCollectorInterface[]
     */
    private $collectors = [];
    private $logger;
    private $initiallyEnabled = \true;
    private $enabled = \true;
    public function __construct(\ECSPrefix20210608\Symfony\Component\HttpKernel\Profiler\ProfilerStorageInterface $storage, \ECSPrefix20210608\Psr\Log\LoggerInterface $logger = null, bool $enable = \true)
    {
        $this->storage = $storage;
        $this->logger = $logger;
        $this->initiallyEnabled = $this->enabled = $enable;
    }
    /**
     * Disables the profiler.
     */
    public function disable()
    {
        $this->enabled = \false;
    }
    /**
     * Enables the profiler.
     */
    public function enable()
    {
        $this->enabled = \true;
    }
    /**
     * Loads the Profile for the given Response.
     *
     * @return Profile|null A Profile instance
     */
    public function loadProfileFromResponse(\ECSPrefix20210608\Symfony\Component\HttpFoundation\Response $response)
    {
        if (!($token = $response->headers->get('X-Debug-Token'))) {
            return null;
        }
        return $this->loadProfile($token);
    }
    /**
     * Loads the Profile for the given token.
     *
     * @return Profile|null A Profile instance
     */
    public function loadProfile(string $token)
    {
        return $this->storage->read($token);
    }
    /**
     * Saves a Profile.
     *
     * @return bool
     */
    public function saveProfile(\ECSPrefix20210608\Symfony\Component\HttpKernel\Profiler\Profile $profile)
    {
        // late collect
        foreach ($profile->getCollectors() as $collector) {
            if ($collector instanceof \ECSPrefix20210608\Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface) {
                $collector->lateCollect();
            }
        }
        if (!($ret = $this->storage->write($profile)) && null !== $this->logger) {
            $this->logger->warning('Unable to store the profiler information.', ['configured_storage' => \get_class($this->storage)]);
        }
        return $ret;
    }
    /**
     * Purges all data from the storage.
     */
    public function purge()
    {
        $this->storage->purge();
    }
    /**
     * Finds profiler tokens for the given criteria.
     *
     * @param string|null $limit The maximum number of tokens to return
     * @param string|null $start The start date to search from
     * @param string|null $end   The end date to search to
     *
     * @return array An array of tokens
     *
     * @see https://php.net/datetime.formats for the supported date/time formats
     * @param string|null $ip
     * @param string|null $url
     * @param string|null $method
     */
    public function find($ip, $url, $limit, $method, $start, $end, string $statusCode = null)
    {
        return $this->storage->find($ip, $url, $limit, $method, $this->getTimestamp($start), $this->getTimestamp($end), $statusCode);
    }
    /**
     * Collects data for the given Response.
     *
     * @return Profile|null A Profile instance or null if the profiler is disabled
     */
    public function collect(\ECSPrefix20210608\Symfony\Component\HttpFoundation\Request $request, \ECSPrefix20210608\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception = null)
    {
        if (\false === $this->enabled) {
            return null;
        }
        $profile = new \ECSPrefix20210608\Symfony\Component\HttpKernel\Profiler\Profile(\substr(\hash('sha256', \uniqid(\mt_rand(), \true)), 0, 6));
        $profile->setTime(\time());
        $profile->setUrl($request->getUri());
        $profile->setMethod($request->getMethod());
        $profile->setStatusCode($response->getStatusCode());
        try {
            $profile->setIp($request->getClientIp());
        } catch (\ECSPrefix20210608\Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException $e) {
            $profile->setIp('Unknown');
        }
        if ($prevToken = $response->headers->get('X-Debug-Token')) {
            $response->headers->set('X-Previous-Debug-Token', $prevToken);
        }
        $response->headers->set('X-Debug-Token', $profile->getToken());
        foreach ($this->collectors as $collector) {
            $collector->collect($request, $response, $exception);
            // we need to clone for sub-requests
            $profile->addCollector(clone $collector);
        }
        return $profile;
    }
    public function reset()
    {
        foreach ($this->collectors as $collector) {
            $collector->reset();
        }
        $this->enabled = $this->initiallyEnabled;
    }
    /**
     * Gets the Collectors associated with this profiler.
     *
     * @return array An array of collectors
     */
    public function all()
    {
        return $this->collectors;
    }
    /**
     * Sets the Collectors associated with this profiler.
     *
     * @param DataCollectorInterface[] $collectors An array of collectors
     */
    public function set(array $collectors = [])
    {
        $this->collectors = [];
        foreach ($collectors as $collector) {
            $this->add($collector);
        }
    }
    /**
     * Adds a Collector.
     */
    public function add(\ECSPrefix20210608\Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface $collector)
    {
        $this->collectors[$collector->getName()] = $collector;
    }
    /**
     * Returns true if a Collector for the given name exists.
     *
     * @param string $name A collector name
     *
     * @return bool
     */
    public function has(string $name)
    {
        return isset($this->collectors[$name]);
    }
    /**
     * Gets a Collector by name.
     *
     * @param string $name A collector name
     *
     * @return DataCollectorInterface A DataCollectorInterface instance
     *
     * @throws \InvalidArgumentException if the collector does not exist
     */
    public function get(string $name)
    {
        if (!isset($this->collectors[$name])) {
            throw new \InvalidArgumentException(\sprintf('Collector "%s" does not exist.', $name));
        }
        return $this->collectors[$name];
    }
    /**
     * @param string|null $value
     * @return int|null
     */
    private function getTimestamp($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }
        try {
            $value = new \DateTime(\is_numeric($value) ? '@' . $value : $value);
        } catch (\Exception $e) {
            return null;
        }
        return $value->getTimestamp();
    }
}
