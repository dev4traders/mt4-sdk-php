<?php

namespace D4T\MT4Sdk\Actions;

trait ManagesTrades
{
    public function deleteTrade(int $ticket): void
    {
        $this->delete("trades/{$ticket}");
    }
}
