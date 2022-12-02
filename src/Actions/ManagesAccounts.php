<?php

namespace D4T\MT4Sdk\Actions;

use D4T\MT4Sdk\Resources\Account;
use Illuminate\Support\Collection;

trait ManagesAccounts
{
    public function listAccountLogins() :Collection
    {
        $accounts = $this->get("users");

        return collect($accounts);
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

    public function deleteAccount(int $login)
    {
        return $this->delete("user/{$login}");
    }

}
