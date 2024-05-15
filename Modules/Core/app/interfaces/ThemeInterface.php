<?php 

namespace Modules\Core\Interfaces;

use Illuminate\Support\Collection;

interface ThemeInterface{
    public function getLangPublicPath(): string;

    public function getVersion(): string;

    public function getScreenshot(): string;

    public function getInfo(bool $assoc = false): null|array|Collection;

    public function getConfigFields(): array;

    public function isActive(): bool;

    public function active(): void;

    public function getTemplate(): string;

    public function getRegister($key = null, $default = null): string|null|array;
}