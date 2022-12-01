<?php

namespace D4T\MT4Sdk\Actions;

use D4T\MT4Sdk\Resources\Symbol;

trait ManagesSymbols
{

    public function symbol(string $name): Symbol
    {
        $attributes = $this->get("symbols/{$name}")['data'];

        return new Symbol($attributes, $this);
    }

}
