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
namespace PhpCsFixer\Fixer\PhpTag;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * Fixer for rules defined in PSR1 ¶2.1.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class FullOpeningTagFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition() : \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('PHP code must use the long `<?php` tags or short-echo `<?=` tags and not other tag variations.', [new \PhpCsFixer\FixerDefinition\CodeSample('<?

echo "Hello!";
')]);
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority() : int
    {
        // must run before all Token-based fixers
        return 98;
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens) : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     * @return void
     */
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokensOrg)
    {
        $content = $tokensOrg->generateCode();
        // replace all <? with <?php to replace all short open tags even without short_open_tag option enabled
        $newContent = \PhpCsFixer\Preg::replace('/<\\?(?:phP|pHp|pHP|Php|PhP|PHp|PHP)?(\\s|$)/', '<?php$1', $content, -1, $count);
        if (!$count) {
            return;
        }
        /* the following code is magic to revert previous replacements which should NOT be replaced, for example incorrectly replacing
         * > echo '<? ';
         * with
         * > echo '<?php ';
         */
        $tokens = \PhpCsFixer\Tokenizer\Tokens::fromCode($newContent);
        $tokensOldContentLength = 0;
        foreach ($tokens as $index => $token) {
            if ($token->isGivenKind(\T_OPEN_TAG)) {
                $tokenContent = $token->getContent();
                if ('<?php' !== \strtolower(\substr($content, $tokensOldContentLength, 5))) {
                    $tokenContent = '<? ';
                }
                $tokensOldContentLength += \strlen($tokenContent);
                continue;
            }
            if ($token->isGivenKind([\T_COMMENT, \T_DOC_COMMENT, \T_CONSTANT_ENCAPSED_STRING, \T_ENCAPSED_AND_WHITESPACE, \T_STRING])) {
                $tokenContent = '';
                $tokenContentLength = 0;
                $parts = \explode('<?php', $token->getContent());
                $iLast = \count($parts) - 1;
                foreach ($parts as $i => $part) {
                    $tokenContent .= $part;
                    $tokenContentLength += \strlen($part);
                    if ($i !== $iLast) {
                        $originalTokenContent = \substr($content, $tokensOldContentLength + $tokenContentLength, 5);
                        if ('<?php' === \strtolower($originalTokenContent)) {
                            $tokenContent .= $originalTokenContent;
                            $tokenContentLength += 5;
                        } else {
                            $tokenContent .= '<?';
                            $tokenContentLength += 2;
                        }
                    }
                }
                $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([$token->getId(), $tokenContent]);
                $token = $tokens[$index];
            }
            $tokensOldContentLength += \strlen($token->getContent());
        }
        $tokensOrg->overrideRange(0, $tokensOrg->count() - 1, $tokens);
    }
}
