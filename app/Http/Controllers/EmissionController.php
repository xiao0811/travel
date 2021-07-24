<?php

namespace App\Http\Controllers;

use App\Models\Emission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmissionController extends Controller
{
    public function get(Request  $request)
    {
        $user = Auth::user();
        $emissions = Emission::query()->where("user_id", $user->id)
            ->orderBy("created_at", "DESC")->get();

        return $this->returnSuccess($emissions);
    }
}
