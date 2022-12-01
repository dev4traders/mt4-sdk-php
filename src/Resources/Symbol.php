<?php

namespace D4T\MT4Sdk\Resources;

class Symbol extends ApiResource
{
    public string $name;

    public string $group;

    public function save(): self
    {
        $symbol = $this->manager->updateSymbol($this->name, $this->toArray());

        $this->attributes = $symbol->toArray();

        $this->fill();

        return $this;
    }

    public function delete(): void
    {
        $this->manager->deleteSymbol($this->name);
    }

}
