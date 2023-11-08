<?php

namespace App\Http\Controllers\letter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Letter\Group;
use App\Models\Letter\Subgroup;

class LettersController extends Controller
{
    public function fetch_groups()
    {
        $data = Group::get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
