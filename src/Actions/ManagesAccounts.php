<?php

namespace D4T\MT4Sdk\Actions;

use D4T\MT4Sdk\Resources\Account;

trait ManagesAccounts
{
    public function listAccountLogins()
    {
        $accounts = $this->get("users");

        return $accounts;
    }

    public function getAccount(int $login): Account
    {
        $attributes = $this->get("user/{$login}");

        return new Account($attributes, $this);
    }

    public function createAccount(array $data): Account
    {
        $attributes = $this->post('user/add', $data)['user'];

        return new Account($attributes, $this);
    }

    public function updateAccount(int $login, array $data): Account
    {
        $attributes = $this->post("user/update/{$login}", $data)['user'];

        return new Account($attributes, $this);
    }

    public function deleteAccount(int $login) : string
    {
        $this->delete("user/{$login}");

        return true;
    }

}
