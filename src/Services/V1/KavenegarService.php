<?php

namespace Callmeaf\Kavenegar\Services\V1;

use Callmeaf\Kavenegar\Services\V1\Contracts\KavenegarServiceInterface;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavenegarService extends SmsService implements KavenegarServiceInterface
{
    public function getApiKey(): string
    {
        return config('callmeaf-kavenegar.api_key');
    }

    public function getApiUrl(string $append = ''): string
    {
        return config('callmeaf-kavenegar.api_url') . $append;
    }

    public function http(): PendingRequest
    {
        return Http::baseUrl($this->getApiUrl('/' . $this->getApiKey()));
    }

    public function send(string $mobile, string $message): Response
    {
        $data = [
            'receptor' => $mobile,
            'message' => $message,
        ];
        $response =  $this->http()->get('/sms/send.json',$data);

        $body = json_decode($response->body(),true);
        $result = $body['return'];
        if(@$result['status'] !== '200') {
            throw new \Exception(@$result['message'] ?? __('callmeaf-base::v1.unknown_error'));
        }

        return $response;
    }

   public function multiSend(array $mobiles, array $messages, array $senders): Response
   {
       $data = [
           'receptor' => $mobiles,
           'sender' => $senders,
           'message' => $messages,
       ];
       $response =  $this->http()->get('/sms/sendarray.json',$data);

       $body = json_decode($response->body(),true);
       $result = $body['return'];
       if(@$result['status'] !== '200') {
           throw new \Exception(@$result['message'] ?? __('callmeaf-base::v1.unknown_error'));
       }

       return $response;
   }

    public function sendViaPattern(string $pattern, string $mobile, array $values): Response
    {
        $keys = config('callmeaf-kavenegar.patterns.verify_otp.keys');
        $data = [
            'receptor' => $mobile,
            'template' => $pattern,
        ];
        foreach ($values as $index => $value) {
            if(!isset($keys[$index])) {
                break;
            }
            $data[$keys[$index]] = $value;
        }
        $response =  $this->http()->get('/verify/lookup.json',$data);

        $body = json_decode($response->body(),true);
        $result = $body['return'];
        if(@$result['status'] !== '200') {
            throw new \Exception(@$result['message'] ?? __('callmeaf-base::v1.unknown_error'));
        }

        return $response;
    }

    public function verifyOtpPattern(): string
    {
        return config('callmeaf-kavenegar.patterns.verify_otp.template');
    }

    public function verifyForgotPasswordCodePattern(): string
    {
        return config('callmeaf-kavenegar.patterns.verify_forgot_password_code.template');
    }
}
