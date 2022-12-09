<?php

namespace D4T\MT4Sdk\Requests;

class TerminalAccountCreateRequest {

    public function __construct(
        public string $Host,
        public int $Port,

        public int $Leverage,
        public float $Balance,
        public string $Name,
        public string $Email,
        public string $TerminalCompany,
        public string $Country,
        public string $City,
        public string $State,
        public string $Zip,
        public string $Address,
        public string $Phone,
        public string $AccountType = 'demoforex'
    ) {

    }

}