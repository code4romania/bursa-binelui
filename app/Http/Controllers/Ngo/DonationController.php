<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\DonationCollection;
use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class DonationController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('AdminOng/Donations/Index', [
            'filter' => $request->query('filter'),
            'collection' => new DonationCollection(
                QueryBuilder::for(Donation::class)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->with('project:id,name,organization_id')
                    ->allowedSorts('created_at', 'amount')
                    ->defaultSorts('-created_at')
                    ->paginate()
                    ->withQueryString()
            ),
        ]);
    }
}
