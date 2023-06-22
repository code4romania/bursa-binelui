<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Donation;
use App\Models\Organization;

class EuPlatescService
{
    private string $merchantId;

    private string $privateKey;

    private bool $testMode;

    private string $url;

    public function __construct($organizationId)
    {
        $organization = Organization::findOrFail($organizationId);
        $this->merchantId = $organization->eu_platesc_merchant_id;
        $this->privateKey = $organization->eu_platesc_private_key;
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
        $data['ExtraData[backtosite]'] = route('project', $donation->project->slug);
        $data['payment_url'] = $this->url;

        return $data;
    }

    private function euPlatescHash($data): string
    {
        $str = null;
        foreach ($data as $d) {
            if ($d === null || \strlen($d) == 0) {
                $str .= '-';
            } else {
                $str .= \strlen($d) . $d;
            }
        }

        return hash_hmac('MD5', $str, pack('H*', $this->privateKey));
    }
}
