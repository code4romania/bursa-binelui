<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        Donation::where('organization_id', auth()->user()->organization_id)->paginate(16)->withQueryString();

        return view('donation.index');
    }
}
