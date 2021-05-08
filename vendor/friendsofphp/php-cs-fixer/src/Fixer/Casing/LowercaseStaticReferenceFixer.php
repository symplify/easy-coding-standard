<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Fixer\Casing;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\FixerDefinition\VersionSpecification;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSample;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Kuba Werłos <werlos@gmail.com>
 */
final class LowercaseStaticReferenceFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Class static references `self`, `static` and `parent` MUST be in lower case.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?php
class Foo extends Bar
{
    public function baz1()
    {
        return STATIC::baz2();
    }

    public function baz2($x)
    {
        return $x instanceof Self;
    }

    public function baz3(PaRent $x)
    {
        return true;
    }
}
'), new \PhpCsFixer\FixerDefinition\VersionSpecificCodeSample('<?php
class Foo extends Bar
{
    public function baz(?self $x) : SELF
    {
        return false;
    }
}
', new \PhpCsFixer\FixerDefinition\VersionSpecification(70100))]);
    }
    /**
     * @return bool
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_STATIC, \T_STRING]);
    }
    /**
     * @return void
     */
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->equalsAny([[\T_STRING, 'self'], [\T_STATIC, 'static'], [\T_STRING, 'parent']], \false)) {
                continue;
            }
            $newContent = \strtolower($token->getContent());
            if ($token->getContent() === $newContent) {
                continue;
                // case is already correct
            }
            $prevIndex = $tokens->getPrevMeaningfulToken($index);
            if ($tokens[$prevIndex]->isGivenKind([\T_CONST, \T_DOUBLE_COLON, \T_FUNCTION, \T_NAMESPACE, \T_NS_SEPARATOR, \T_PRIVATE, \T_PROTECTED, \T_PUBLIC]) || $tokens[$prevIndex]->isObjectOperator()) {
                continue;
            }
            $nextIndex = $tokens->getNextMeaningfulToken($index);
            if ($tokens[$nextIndex]->isGivenKind([\T_FUNCTION, \T_NS_SEPARATOR, \T_PRIVATE, \T_PROTECTED, \T_PUBLIC])) {
                continue;
            }
            if ('static' === $newContent && $tokens[$nextIndex]->isGivenKind(\T_VARIABLE)) {
                continue;
            }
            $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([$token->getId(), $newContent]);
        }
    }
}