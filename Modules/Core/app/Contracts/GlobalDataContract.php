<?php

namespace Modules\Core\Contracts;

interface GlobalDataContract
{
    public function set(string $key, string|array $value);
    public function push(string $key, string|array $value): void;
    public function get(string $key, string|array $default = null): string|array;
    public function all(): array;
}