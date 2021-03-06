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
namespace PhpCsFixer\Linter;

/**
 * Interface for PHP code linting process manager.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
interface LinterInterface
{
    public function isAsync() : bool;
    /**
     * Lint PHP file.
     * @param string $path
     */
    public function lintFile($path) : \PhpCsFixer\Linter\LintingResultInterface;
    /**
     * Lint PHP code.
     * @param string $source
     */
    public function lintSource($source) : \PhpCsFixer\Linter\LintingResultInterface;
}
