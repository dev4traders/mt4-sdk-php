<?php

namespace D4T\MT4Sdk\Actions;

use D4T\MT4Sdk\Resources\Account;

trait ManagesAccounts
{
    public function getAccounts()
    {
        $accounts = $this->get("users");

        return [];

        //return new Account($attributes, $this);
    }

    public function getAccount(int $login): Account
    {
        $attributes = $this->get("user/{$login}")['data'];

        return new Account($attributes, $this);
    }

    public function createAccount(array $data): Account
    {
        $attributes = $this->post('user/add', $data);

        return new Account($attributes, $this);
    }

    public function updateAccount(int $login, array $data): Account
    {
        $attributes = $this->put("user/update/{$login}", $data)['data'];

        return new Account($attributes, $this);
    }

    public function deleteAccount(int $login): void
    {
        $this->delete("user/{$login}");
    }

}
