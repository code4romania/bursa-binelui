<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Donations\EuPlatescRequest;
use App\Models\Donation;
use App\Notifications\Ngo\DonationReceived;
use App\Notifications\UserDonationReceived;
use App\Services\EuPlatescService;
use Illuminate\Support\Facades\Notification;
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
        $donation = Donation::where('uuid', $uuid)->firstOrFail();
        \Log::info('Donation ' . $donation->id . 'was updated in DB');

        Notification::route('mail', $donation->email)
            ->notify(new UserDonationReceived($donation));

        $organizationsUsers = $donation->load('organization')
            ->organization->load('users')->users->filter(function ($user) {
                return $user->hasVerifiedEmail();
            });

        \Notification::send($organizationsUsers, new DonationReceived());

        return Inertia::render('Public/Donor/ThankYou');
    }

    public function euPlatescCallback(EuPlatescRequest $request, Donation $donation)
    {
        $validatedData = $request->validated();

        (new EuPlatescService($donation->organization_id))->processIpn($donation, $validatedData);

        echo 'OK'; //IMPORTANT to print OK
    }
}
