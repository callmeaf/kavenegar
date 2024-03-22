<?php

namespace Callmeaf\Kavenegar\Services\V1;

use Callmeaf\Kavenegar\Services\V1\Contracts\KavenegarServiceInterface;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavenegarService extends SmsService implements KavenegarServiceInterface
{
    public function getApiUrl(): string
    {
        return 'https://api.kavenegar.com/v1/'. config('callmeaf-kavenegar.api_key')  .'/verify/lookup.json';
    }

    public function sendViaPattern(string $pattern, string $mobile, array $values): Response
    {
        $data = [
            'receptor' => $mobile,
            'template' => $pattern,
        ];
        foreach ($values as $index => $value) {
            if($index > 3) {
                break;
            }
            if($index === 0) {
                $data['token'] = $value;
            } else {
                $data["token" . $index + 1] = $value;
            }
        }
        $response =  Http::get($this->getApiUrl(),$data);
        $body = json_decode($response->body(),true);
        $result = $body['return'];
        if(@$result['status'] !== '200') {
            throw new \Exception(@$result['message'] ?? __('callmeaf-base::v1.unknown_error'));
        }

        Log::alert(json_encode($response->headers()));
        Log::alert($response->body());
        Log::alert($response->status());
        return $response;
    }

    public function verifyOtpPattern(): string
    {
        return config('callmeaf-kavenegar.patterns.verify_otp.template');
    }
}
