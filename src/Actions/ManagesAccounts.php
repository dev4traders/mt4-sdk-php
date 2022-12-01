<?php

namespace D4T\MT4Sdk\Actions;

use D4T\MT4Sdk\Resources\Account;

trait ManagesAccounts
{
    public function account(int $login): Account
    {
        $attributes = $this->get("accounts/{$login}")['data'];

        return new Account($attributes, $this);
    }

    public function createAccount(array $data): Account
    {
        $attributes = $this->post('accounts', $data);

        return new Account($attributes, $this);
    }

    public function updateAccount(int $login, array $data): Account
    {
        $attributes = $this->put("accounts/{$login}", $data)['data'];

        return new Account($attributes, $this);
    }

    public function deleteAccount(int $login): void
    {
        $this->delete("accounts/{$login}");
    }

}
