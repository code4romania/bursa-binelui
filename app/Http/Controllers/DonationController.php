<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        Donation::where('organization_id', auth()->user()->organization_id)->paginate(16)->withQueryString();

        return view('donation.index');
    }
}
