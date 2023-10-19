<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {

        $travels = Travel::query()
            ->where('is_public', true)
            ->paginate(10);

        return TravelResource::collection($travels);
    }
}
