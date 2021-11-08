<?php

declare(strict_types=1);

namespace Medas\Test;

use Medas\Core\Directory;
use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase
{
    public function testRecursiveByExtension(): void
    {
        $files = iterator_to_array(Directory::recursiveFindByExtension(__DIR__, 'php'));
        $this->assertContains(__FILE__, $files);
        $this->assertArrayHasKey(__FILE__, $files);

    }
}
