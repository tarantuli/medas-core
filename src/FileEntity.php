<?php

declare(strict_types=1);

namespace Medas\Core;

interface FileEntity
{
    public function setContent(string $content): self;

    public function setName(?string $name): self;

    public function name(): ?string;

    public function mimetype(): string;

    public function content(): string;

    public function contentHash(): string;
}
