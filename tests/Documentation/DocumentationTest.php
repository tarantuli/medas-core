<?php

declare(strict_types=1);

namespace Documentation;

use Medas\CoreTest\BaseTestClass;

class DocumentationTest extends BaseTestClass
{
    public function testPackages(): void
    {
        $markdown = file_get_contents(__DIR__ . '/../../docs/packages.md');
        $paths = glob(__DIR__ . '/../../../*', GLOB_ONLYDIR);

        $toSkip = [
            'base-backend',
            'basic-request-handler',
            'core',
            'html-entity-browser',
            'package-base',
            'song-title-analyzer',
        ];

        foreach ($paths as $path) {
            $package = pathinfo($path, PATHINFO_BASENAME);

            if (in_array($package, $toSkip, true)) {
                continue;
            }

            self::assertStringContainsString(
                '/medas-' . $package,
                $markdown,
                'packages.md does not contain ' . $package
            );
        }
    }
}
