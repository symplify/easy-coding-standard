<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210623\Symfony\Component\HttpKernel\HttpCache;

use ECSPrefix20210623\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210623\Symfony\Component\HttpFoundation\Response;
use ECSPrefix20210623\Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * Abstract class implementing Surrogate capabilities to Request and Response instances.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
abstract class AbstractSurrogate implements \ECSPrefix20210623\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface
{
    protected $contentTypes;
    protected $phpEscapeMap = [['<?', '<%', '<s', '<S'], ['<?php echo "<?"; ?>', '<?php echo "<%"; ?>', '<?php echo "<s"; ?>', '<?php echo "<S"; ?>']];
    /**
     * @param array $contentTypes An array of content-type that should be parsed for Surrogate information
     *                            (default: text/html, text/xml, application/xhtml+xml, and application/xml)
     */
    public function __construct(array $contentTypes = ['text/html', 'text/xml', 'application/xhtml+xml', 'application/xml'])
    {
        $this->contentTypes = $contentTypes;
    }
    /**
     * Returns a new cache strategy instance.
     *
     * @return ResponseCacheStrategyInterface A ResponseCacheStrategyInterface instance
     */
    public function createCacheStrategy()
    {
        return new \ECSPrefix20210623\Symfony\Component\HttpKernel\HttpCache\ResponseCacheStrategy();
    }
    /**
     * {@inheritdoc}
     */
    public function hasSurrogateCapability(\ECSPrefix20210623\Symfony\Component\HttpFoundation\Request $request)
    {
        if (null === ($value = $request->headers->get('Surrogate-Capability'))) {
            return \false;
        }
        return \false !== \strpos($value, \sprintf('%s/1.0', \strtoupper($this->getName())));
    }
    /**
     * {@inheritdoc}
     */
    public function addSurrogateCapability(\ECSPrefix20210623\Symfony\Component\HttpFoundation\Request $request)
    {
        $current = $request->headers->get('Surrogate-Capability');
        $new = \sprintf('symfony="%s/1.0"', \strtoupper($this->getName()));
        $request->headers->set('Surrogate-Capability', $current ? $current . ', ' . $new : $new);
    }
    /**
     * {@inheritdoc}
     */
    public function needsParsing(\ECSPrefix20210623\Symfony\Component\HttpFoundation\Response $response)
    {
        if (!($control = $response->headers->get('Surrogate-Control'))) {
            return \false;
        }
        $pattern = \sprintf('#content="[^"]*%s/1.0[^"]*"#', \strtoupper($this->getName()));
        return (bool) \preg_match($pattern, $control);
    }
    /**
     * {@inheritdoc}
     */
    public function handle(\ECSPrefix20210623\Symfony\Component\HttpKernel\HttpCache\HttpCache $cache, string $uri, string $alt, bool $ignoreErrors)
    {
        $subRequest = \ECSPrefix20210623\Symfony\Component\HttpFoundation\Request::create($uri, \ECSPrefix20210623\Symfony\Component\HttpFoundation\Request::METHOD_GET, [], $cache->getRequest()->cookies->all(), [], $cache->getRequest()->server->all());
        try {
            $response = $cache->handle($subRequest, \ECSPrefix20210623\Symfony\Component\HttpKernel\HttpKernelInterface::SUB_REQUEST, \true);
            if (!$response->isSuccessful()) {
                throw new \RuntimeException(\sprintf('Error when rendering "%s" (Status code is %d).', $subRequest->getUri(), $response->getStatusCode()));
            }
            return $response->getContent();
        } catch (\Exception $e) {
            if ($alt) {
                return $this->handle($cache, $alt, '', $ignoreErrors);
            }
            if (!$ignoreErrors) {
                throw $e;
            }
        }
        return '';
    }
    /**
     * Remove the Surrogate from the Surrogate-Control header.
     */
    protected function removeFromControl(\ECSPrefix20210623\Symfony\Component\HttpFoundation\Response $response)
    {
        if (!$response->headers->has('Surrogate-Control')) {
            return;
        }
        $value = $response->headers->get('Surrogate-Control');
        $upperName = \strtoupper($this->getName());
        if (\sprintf('content="%s/1.0"', $upperName) == $value) {
            $response->headers->remove('Surrogate-Control');
        } elseif (\preg_match(\sprintf('#,\\s*content="%s/1.0"#', $upperName), $value)) {
            $response->headers->set('Surrogate-Control', \preg_replace(\sprintf('#,\\s*content="%s/1.0"#', $upperName), '', $value));
        } elseif (\preg_match(\sprintf('#content="%s/1.0",\\s*#', $upperName), $value)) {
            $response->headers->set('Surrogate-Control', \preg_replace(\sprintf('#content="%s/1.0",\\s*#', $upperName), '', $value));
        }
    }
}
