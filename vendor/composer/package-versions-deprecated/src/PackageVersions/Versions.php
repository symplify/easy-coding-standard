<?php

namespace ECSPrefix20210508\PackageVersions;

use ECSPrefix20210508\Composer\InstalledVersions;
use OutOfBoundsException;
\class_exists(\ECSPrefix20210508\Composer\InstalledVersions::class);
/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'symplify/easy-coding-standard';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS = array('composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6', 'composer/semver' => '3.2.4@a02fdf930a3c1c3ed3a49b5f63859c0c20e10464', 'composer/xdebug-handler' => '2.0.1@964adcdd3a28bf9ed5d9ac6450064e0d71ed7496', 'doctrine/annotations' => '1.12.1@b17c5014ef81d212ac539f07a1001832df1b6d3b', 'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042', 'friendsofphp/php-cs-fixer' => 'v3.0.0@c15377bdfa8d1ecf186f1deadec39c89984e1167', 'jean85/pretty-package-versions' => '2.0.3@b2c4ec2033a0196317a467cb197c7c843b794ddf', 'nette/neon' => 'v3.2.2@e4ca6f4669121ca6876b1d048c612480e39a28d5', 'nette/utils' => 'v3.2.2@967cfc4f9a1acd5f1058d76715a424c53343c20c', 'php-cs-fixer/diff' => 'v2.0.2@29dc0d507e838c4580d018bd8b5cb412474f7ec3', 'psr/cache' => '2.0.0@213f9dbc5b9bfbc4f8db86d2838dc968752ce13b', 'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf', 'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0', 'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11', 'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b', 'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d', 'squizlabs/php_codesniffer' => '3.6.0@ffced0d2c8fa8e6cdc4d695a743271fab6c38625', 'symfony/cache' => 'v5.2.7@1d801d1dc5e3840e832568db6b35a954cfb435a8', 'symfony/cache-contracts' => 'v2.4.0@c0446463729b89dd4fa62e9aeecc80287323615d', 'symfony/config' => 'v5.2.7@3817662ada105c8c4d1afdb4ec003003efd1d8d8', 'symfony/console' => 'v5.2.7@90374b8ed059325b49a29b55b3f8bb4062c87629', 'symfony/dependency-injection' => 'v5.2.7@6ca378b99e3c9ba6127eb43b68389fb2b7348577', 'symfony/deprecation-contracts' => 'v2.4.0@5f38c8804a9e97d23e0c8d63341088cd8a22d627', 'symfony/error-handler' => 'v5.2.7@ea3ddbf67615e883ca7c33a4de61213789846782', 'symfony/event-dispatcher' => 'v5.2.4@d08d6ec121a425897951900ab692b612a61d6240', 'symfony/event-dispatcher-contracts' => 'v2.4.0@69fee1ad2332a7cbab3aca13591953da9cdb7a11', 'symfony/filesystem' => 'v5.2.7@056e92acc21d977c37e6ea8e97374b2a6c8551b0', 'symfony/finder' => 'v5.2.4@0d639a0943822626290d169965804f79400e6a04', 'symfony/http-client-contracts' => 'v2.4.0@7e82f6084d7cae521a75ef2cb5c9457bbda785f4', 'symfony/http-foundation' => 'v5.2.7@a416487a73bb9c9d120e9ba3a60547f4a3fb7a1f', 'symfony/http-kernel' => 'v5.2.7@1e9f6879f070f718e0055fbac232a56f67b8b6bd', 'symfony/options-resolver' => 'v5.2.4@5d0f633f9bbfcf7ec642a2b5037268e61b0a62ce', 'symfony/polyfill-ctype' => 'v1.22.1@c6c942b1ac76c82448322025e084cadc56048b4e', 'symfony/polyfill-intl-grapheme' => 'v1.22.1@5601e09b69f26c1828b13b6bb87cb07cddba3170', 'symfony/polyfill-intl-normalizer' => 'v1.22.1@43a0283138253ed1d48d352ab6d0bdb3f809f248', 'symfony/polyfill-php73' => 'v1.22.1@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2', 'symfony/polyfill-php80' => 'v1.22.1@dc3063ba22c2a1fd2f45ed856374d79114998f91', 'symfony/process' => 'v5.2.7@98cb8eeb72e55d4196dd1e36f1f16e7b3a9a088e', 'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb', 'symfony/stopwatch' => 'v5.2.7@d99310c33e833def36419c284f60e8027d359678', 'symfony/string' => 'v5.2.6@ad0bd91bce2054103f5eaa18ebeba8d3bc2a0572', 'symfony/var-dumper' => 'v5.2.7@27cb9f7cfa3853c736425c7233a8f68814b19636', 'symfony/var-exporter' => 'v5.2.7@01184a5ab95eb9500b9b0ef3e525979e003d9c81', 'symplify/autowire-array-parameter' => 'dev-main@082531e1758f170dec639ec9cd5858f94bc208f6', 'symplify/coding-standard' => 'dev-main@93bd0efc7dc3ec640c1d49b1bc34dec3df759ff6', 'symplify/composer-json-manipulator' => 'dev-main@a58d9f73bb7f756b720428566761854a44d86641', 'symplify/console-color-diff' => 'dev-main@1572b114d39499757fa2d7d46367fc41ba07e006', 'symplify/console-package-builder' => 'dev-main@072420b8373cd28e617dbccd7abdef4e5a5a2871', 'symplify/easy-testing' => 'dev-main@d12b5b2772dc757b3b6141819fac9b71287095e4', 'symplify/package-builder' => 'dev-main@be792b98451e1d6098dc76fcbcc64a664b597239', 'symplify/rule-doc-generator-contracts' => 'dev-main@b661f9642938eb64d076c4eff25ad4ffc439ef8c', 'symplify/set-config-resolver' => 'dev-main@01defc375e33a7a65f747165afe7ad695f92a0d0', 'symplify/skipper' => 'dev-main@5db8993e3167f28b60516b17de50c937df17ba75', 'symplify/smart-file-system' => 'dev-main@2dea618353e3da36cb4244b28f0ca41387d764f2', 'symplify/symplify-kernel' => 'dev-main@6ce79f29218bd8b90f70b6ed993c227b8d8bd57f', 'symfony/polyfill-php72' => '*@', 'symfony/polyfill-mbstring' => '*@', 'symplify/easy-coding-standard' => '9.4.x-dev@');
    private function __construct()
    {
    }
    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     * @return string
     */
    public static function rootPackageName()
    {
        if (!\class_exists(\ECSPrefix20210508\Composer\InstalledVersions::class, \false) || !\ECSPrefix20210508\Composer\InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }
        return \ECSPrefix20210508\Composer\InstalledVersions::getRootPackage()['name'];
    }
    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     * @param string $packageName
     * @return string
     */
    public static function getVersion($packageName)
    {
        $packageName = (string) $packageName;
        if (\class_exists(\ECSPrefix20210508\Composer\InstalledVersions::class, \false) && \ECSPrefix20210508\Composer\InstalledVersions::getRawData()) {
            return \ECSPrefix20210508\Composer\InstalledVersions::getPrettyVersion($packageName) . '@' . \ECSPrefix20210508\Composer\InstalledVersions::getReference($packageName);
        }
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }
        throw new \OutOfBoundsException('Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files');
    }
}