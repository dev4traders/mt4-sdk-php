<?php

namespace D4T\MT4Sdk\Resources;

class Trade extends ApiResource
{
    public int $ticket;

    public string $symbol;

    public float $lots;

    public float $price;

    public float $priceClose;

    public function save(): self
    {
        $trade = $this->manager->updateTrade($this->ticket, $this->toArray());

        $this->attributes = $trade->toArray();

        $this->fill();

        return $this;
    }

    public function delete(): self
    {
        $this->manager->deleteTrade($this->ticket);

        return $this;
    }
}
