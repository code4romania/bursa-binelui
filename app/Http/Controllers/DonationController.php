<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\EuPlatescService;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function index()
    {
        Donation::where('organization_id', auth()->user()->organization_id)->paginate(16)->withQueryString();

        return view('donation.index');
    }

    public function makeDonation(Donation $donation)
    {
        $service = new EuPlatescService($donation->organization_id);
        $data = $service->getPaymentData($donation);

        return Inertia::render('Public/Donor/Donor', [
            'data' => $data,
        ]);
    }

    public function thankYou(string $uuid)
    {
        return Inertia::render('Public/Donor/ThankYou');
    }
}
