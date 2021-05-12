<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210512\Symfony\Component\Console\Output;

use ECSPrefix20210512\Symfony\Component\Console\Formatter\OutputFormatter;
use ECSPrefix20210512\Symfony\Component\Console\Formatter\OutputFormatterInterface;
/**
 * Base class for output classes.
 *
 * There are five levels of verbosity:
 *
 *  * normal: no option passed (normal output)
 *  * verbose: -v (more output)
 *  * very verbose: -vv (highly extended output)
 *  * debug: -vvv (all debug output)
 *  * quiet: -q (no output)
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Output implements \ECSPrefix20210512\Symfony\Component\Console\Output\OutputInterface
{
    private $verbosity;
    private $formatter;
    /**
     * @param int                           $verbosity The verbosity level (one of the VERBOSITY constants in OutputInterface)
     * @param bool                          $decorated Whether to decorate messages
     * @param OutputFormatterInterface|null $formatter Output formatter instance (null to use default OutputFormatter)
     */
    public function __construct($verbosity = self::VERBOSITY_NORMAL, $decorated = \false, \ECSPrefix20210512\Symfony\Component\Console\Formatter\OutputFormatterInterface $formatter = null)
    {
        $decorated = (bool) $decorated;
        $this->verbosity = null === $verbosity ? self::VERBOSITY_NORMAL : $verbosity;
        $this->formatter = isset($formatter) ? $formatter : new \ECSPrefix20210512\Symfony\Component\Console\Formatter\OutputFormatter();
        $this->formatter->setDecorated($decorated);
    }
    /**
     * {@inheritdoc}
     */
    public function setFormatter(\ECSPrefix20210512\Symfony\Component\Console\Formatter\OutputFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }
    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
        return $this->formatter;
    }
    /**
     * {@inheritdoc}
     * @param bool $decorated
     */
    public function setDecorated($decorated)
    {
        $decorated = (bool) $decorated;
        $this->formatter->setDecorated($decorated);
    }
    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->formatter->isDecorated();
    }
    /**
     * {@inheritdoc}
     * @param int $level
     */
    public function setVerbosity($level)
    {
        $level = (int) $level;
        $this->verbosity = $level;
    }
    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return $this->verbosity;
    }
    /**
     * {@inheritdoc}
     */
    public function isQuiet()
    {
        return self::VERBOSITY_QUIET === $this->verbosity;
    }
    /**
     * {@inheritdoc}
     */
    public function isVerbose()
    {
        return self::VERBOSITY_VERBOSE <= $this->verbosity;
    }
    /**
     * {@inheritdoc}
     */
    public function isVeryVerbose()
    {
        return self::VERBOSITY_VERY_VERBOSE <= $this->verbosity;
    }
    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return self::VERBOSITY_DEBUG <= $this->verbosity;
    }
    /**
     * {@inheritdoc}
     * @param int $options
     */
    public function writeln($messages, $options = self::OUTPUT_NORMAL)
    {
        $options = (int) $options;
        $this->write($messages, \true, $options);
    }
    /**
     * {@inheritdoc}
     * @param bool $newline
     * @param int $options
     */
    public function write($messages, $newline = \false, $options = self::OUTPUT_NORMAL)
    {
        $newline = (bool) $newline;
        $options = (int) $options;
        if (!(\is_array($messages) || $messages instanceof \Traversable)) {
            $messages = [$messages];
        }
        $types = self::OUTPUT_NORMAL | self::OUTPUT_RAW | self::OUTPUT_PLAIN;
        $type = $types & $options ?: self::OUTPUT_NORMAL;
        $verbosities = self::VERBOSITY_QUIET | self::VERBOSITY_NORMAL | self::VERBOSITY_VERBOSE | self::VERBOSITY_VERY_VERBOSE | self::VERBOSITY_DEBUG;
        $verbosity = $verbosities & $options ?: self::VERBOSITY_NORMAL;
        if ($verbosity > $this->getVerbosity()) {
            return;
        }
        foreach ($messages as $message) {
            switch ($type) {
                case \ECSPrefix20210512\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL:
                    $message = $this->formatter->format($message);
                    break;
                case \ECSPrefix20210512\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW:
                    break;
                case \ECSPrefix20210512\Symfony\Component\Console\Output\OutputInterface::OUTPUT_PLAIN:
                    $message = \strip_tags($this->formatter->format($message));
                    break;
            }
            $this->doWrite($message, $newline);
        }
    }
    /**
     * Writes a message to the output.
     * @param string $message
     * @param bool $newline
     */
    protected abstract function doWrite($message, $newline);
}
