<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('panduan.index', compact('user'));
    }

    public function completeTour(Request $request)
    {
        $user = auth()->user();

        if ($user && !$user->has_seen_tour) {
            $user->update(['has_seen_tour' => true]);
        }

        return response()->json(['ok' => true]);
    }
}
