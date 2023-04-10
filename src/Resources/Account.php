<?php

namespace D4T\MT4Sdk\Resources;

class Account extends ApiResource
{
    public int $login;

    public string $name;

    public string $email;

    public string $password;

    public function save(): self
    {
        $account = $this->manager->updateAccount($this->login, $this->toArray());

        $this->attributes = $account->toArray();

        $this->fill();

        return $this;
    }

    public function delete(): self
    {
        $this->manager->deleteAccount($this->login);

        return $this;
    }

}