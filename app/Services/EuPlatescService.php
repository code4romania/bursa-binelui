<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EuPlatescStatus;
use App\Models\Donation;
use App\Models\Organization;
use Http;

class EuPlatescService
{
    public const CAPTURE_METHOD = 'capture';

    private string $merchantId;

    private string $privateKey;

    private string $userKey;

    private string $userApiKey;

    private bool $testMode;

    private string $url;

    public function __construct($organizationId)
    {
        $organization = Organization::findOrFail($organizationId);
        $this->merchantId = $organization->eu_platesc_merchant_id;
        $this->privateKey = $organization->eu_platesc_private_key;
        $this->userKey = $organization->eu_platesc_merchant_id ?? '';
        $this->userApiKey = $organization->eu_platesc_private_key ?? '';

        $this->testMode = config('services.eu_platesc.test_mode');
        $this->url = config('services.eu_platesc.url');
    }

    public function getPaymentData(Donation $donation): array
    {
        $donation->with('project', 'organization');

        $data = [
            'amount' => $donation->amount,
            'curr' => 'RON',
            'invoice_id' => $donation->uuid,
            'order_desc' => "Donatie pentru {$donation->project->name} de la {$donation->first_name} {$donation->last_name} pentru {$donation->organization->name}",
            'merch_id' => $this->merchantId,
            'timestamp' => now()->format('YmdHis'),
            'nonce' => uniqid(),

        ];
        $data['fp_hash'] = $this->euPlatescHash($data);
        $data['fname'] = $donation->first_name;
        $data['lname'] = $donation->last_name;
        $data['ExtraData[silenturl]'] = route('donation.callback', $donation->uuid);
        $data['ExtraData[successurl]'] = route('donation.thanks', $donation->uuid);
        $data['ExtraData[backtosite]'] = route('projects.show', $donation->project->slug);
        $data['payment_url'] = $this->url;

        return $data;
    }

    private function euPlatescHash($data, bool $useApiKey = false): string
    {
        $str = '';
        foreach ($data as $d) {
            if ($d === null || \strlen((string) $d) == 0) {
                $str .= '-';
            } else {
                $str .= \strlen((string) $d) . $d;
            }
        }

        $key = $useApiKey ? $this->userApiKey : $this->privateKey;

        return hash_hmac('MD5', $str, pack('H*', $key));
    }

    public function getRequestIpnData(mixed $validatedData): array
    {
        $data = [
            'amount' => addslashes(trim($validatedData['amount'])),
            'curr' => addslashes(trim($validatedData['curr'])),
            'invoice_id' => addslashes(trim($validatedData['invoice_id'])),
            'ep_id' => addslashes(trim($validatedData['ep_id'])),
            'merch_id' => addslashes(trim($validatedData['merch_id'])),
            'action' => addslashes(trim($validatedData['action'])),
            'message' => addslashes(trim($validatedData['message'])),
            'approval' => addslashes(trim($validatedData['approval'])),
            'timestamp' => addslashes(trim($validatedData['timestamp'])),
            'nonce' => addslashes(trim($validatedData['nonce'])),
        ];

        $params = ['sec_status', 'rrn', 'mcard', 'card_exp', 'discount_amount', 'card_type', 'bin', 'rate',
            'card_holder', 'email', 'rtype', 'cce'];

        foreach ($params as $param) {
            if (! isset($validatedData[$param])) {
                continue;
            }
            $data[$param] = addslashes(trim($validatedData[$param]));
        }

        $data['fp_hash'] = strtoupper($this->euPlatescHash($data));

        return $data;
    }

    public function processIpn(Donation $donation, array $validatedData): void
    {
        $data = $this->getRequestIpnData($validatedData);
        $fp_hash = addslashes(trim($validatedData['fp_hash']));

        if ($data['fp_hash'] !== $fp_hash || $data['action'] != '0') {
            $donation->update(['status' => EuPlatescStatus::UNAUTHORIZED]);

            return;
        }

        $values = ['status' => EuPlatescStatus::AUTHORIZED,
            'ep_id' => $data['ep_id']];
        $donation->update($values);

        $user = $donation->user;
        if ($user) {
            $userBadge = new UserBadge();
            $userBadge->updateDonationBadge($user);
        }

    }

    public function recipeTransaction(Donation $donation): bool
    {
        $data = [
            'method' => self::CAPTURE_METHOD,
            'ukey' => $this->userKey,
            'epid' => $donation->ep_id,
            'timestamp' => gmdate('YmdHis'),
            'nonce' => md5(mt_rand() . time()),
        ];
        $data['fp_hash'] = strtoupper($this->euPlatescHash($data, true));

        $response = $this->callMethod($data);

        if (isset($response['error'])) {
            return false;
        }

        return (bool) $response['success'];
    }

    public function callMethod(array $data): array
    {
        $response = Http::asForm()->post(
            config('euplatesc.url_action'),
            $data
        );

        $body = $response->body() ?: '';

        return json_decode($body, true);
    }

    public function canCaptureTransaction(): bool
    {
        return $this->userKey && $this->userApiKey;
    }
}
