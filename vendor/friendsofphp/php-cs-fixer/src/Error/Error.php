<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Error;

/**
 * An abstraction for errors that can occur before and during fixing.
 *
 * @author Andreas Möller <am@localheinz.com>
 *
 * @internal
 */
final class Error
{
    /**
     * Error which has occurred in linting phase, before applying any fixers.
     */
    const TYPE_INVALID = 1;
    /**
     * Error which has occurred during fixing phase.
     */
    const TYPE_EXCEPTION = 2;
    /**
     * Error which has occurred in linting phase, after applying any fixers.
     */
    const TYPE_LINT = 3;
    /**
     * @var int
     */
    private $type;
    /**
     * @var string
     */
    private $filePath;
    /**
     * @var null|\Throwable
     */
    private $source;
    /**
     * @var array
     */
    private $appliedFixers;
    /**
     * @var null|string
     */
    private $diff;
    /**
     * @param \Throwable|null $source
     * @param string|null $diff
     */
    public function __construct(int $type, string $filePath, $source = null, array $appliedFixers = [], $diff = null)
    {
        $this->type = $type;
        $this->filePath = $filePath;
        $this->source = $source;
        $this->appliedFixers = $appliedFixers;
        $this->diff = $diff;
    }
    public function getFilePath() : string
    {
        return $this->filePath;
    }
    /**
     * @return \Throwable|null
     */
    public function getSource()
    {
        return $this->source;
    }
    public function getType() : int
    {
        return $this->type;
    }
    public function getAppliedFixers() : array
    {
        return $this->appliedFixers;
    }
    /**
     * @return string|null
     */
    public function getDiff()
    {
        return $this->diff;
    }
}
