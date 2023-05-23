<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface FileEntity
{
    public function setContent(string $content): self;

    public function setName(string|null $name): self;

    public function name(): string|null;

    public function mimetype(): string;

    public function content(): string;

    public function contentHash(): string;
}
