<?php

namespace Callmeaf\Kavenegar\Services\V1\Contracts;


use Illuminate\Http\Client\Response;

interface KavenegarServiceInterface
{
    public function getApiUrl(): string;
    public function sendViaPattern(string $pattern,string $mobile,array $values): Response;
}
