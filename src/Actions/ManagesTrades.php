<?php

namespace D4T\MT4Sdk\Actions;

use D4T\MT4Sdk\Resources\Trade;

trait ManagesTrades
{
    public function openTrade(int $accountLogin, array $data): Trade
    {
        $attributes = $this->post('trade/open', $data)['trade'];

        return new Trade($attributes, $this);
    }

    public function closeTrade(int $ticket): void
    {
        $this->delete("trades/{$ticket}");
    }
}
