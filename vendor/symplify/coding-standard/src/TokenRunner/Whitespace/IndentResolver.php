<?php

namespace Symplify\CodingStandard\TokenRunner\Whitespace;

use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\IndentDetector;
final class IndentResolver
{
    /**
     * @var IndentDetector
     */
    private $indentDetector;
    /**
     * @var WhitespacesFixerConfig
     */
    private $whitespacesFixerConfig;
    public function __construct(\Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\IndentDetector $indentDetector, \PhpCsFixer\WhitespacesFixerConfig $whitespacesFixerConfig)
    {
        $this->indentDetector = $indentDetector;
        $this->whitespacesFixerConfig = $whitespacesFixerConfig;
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $startIndex
     * @return string
     */
    public function resolveClosingBracketNewlineWhitespace(\PhpCsFixer\Tokenizer\Tokens $tokens, $startIndex)
    {
        $startIndex = (int) $startIndex;
        $indentLevel = $this->indentDetector->detectOnPosition($tokens, $startIndex);
        return $this->whitespacesFixerConfig->getLineEnding() . \str_repeat($this->whitespacesFixerConfig->getIndent(), $indentLevel);
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $index
     * @return string
     */
    public function resolveCurrentNewlineIndentWhitespace(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $index = (int) $index;
        $indentLevel = $this->indentDetector->detectOnPosition($tokens, $index);
        $indentWhitespace = \str_repeat($this->whitespacesFixerConfig->getIndent(), $indentLevel);
        return $this->whitespacesFixerConfig->getLineEnding() . $indentWhitespace;
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $index
     * @return string
     */
    public function resolveNewlineIndentWhitespace(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $index = (int) $index;
        $indentWhitespace = $this->resolveIndentWhitespace($tokens, $index);
        return $this->whitespacesFixerConfig->getLineEnding() . $indentWhitespace;
    }
    /**
     * @param Tokens<Token> $tokens
     * @param int $index
     * @return string
     */
    private function resolveIndentWhitespace(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $index = (int) $index;
        $indentLevel = $this->indentDetector->detectOnPosition($tokens, $index);
        return \str_repeat($this->whitespacesFixerConfig->getIndent(), $indentLevel + 1);
    }
}