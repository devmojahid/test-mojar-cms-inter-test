<?php

namespace Modules\Core\Supports;

use Modules\Core\Contracts\GlobalDataContract;
use Illuminate\Support\Arr;

class GlobalData implements GlobalDataContract
{
    protected array $values = [];

    public function set(string $key, string|array $value): void
    {
        Arr::set($this->values, $key, $value);
    }

    public function push(string $key, $value): void
    {
        $data = $this->get($key, []);
        $data[] = $value;
        $this->set($key, $data);
    }

    public function get(string $key, $default = null): string|array
    {
        return Arr::get($this->values, $key, $default);
    }

    public function all(): array
    {
        return $this->values;
    }
}
