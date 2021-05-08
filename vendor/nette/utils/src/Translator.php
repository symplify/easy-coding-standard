<?php

namespace ECSPrefix20210508\Nette\Localization;

/**
 * Translator adapter.
 */
interface Translator
{
    /**
     * Translates the given string.
     * @param  mixed  $message
     * @param  mixed  ...$parameters
     * @return string
     */
    function translate($message, ...$parameters);
}
\interface_exists(\ECSPrefix20210508\Nette\Localization\Nette\Localization\ITranslator::class);