<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function index()
    {
        return view('security');
    }

   public function verify(Request $request)
{
    $request->validate([
    'capability_code' => [
        'required',
        'string',
        'min:6',
        'max:20',
    ],
]);

    $user = Auth::user();

    if (!Hash::check($request->capability_code, $user->capability_code)) {

        return back()->with('error', 'Invalid Capability Code.');

    }

    session([
    'capability_verified' => true
]);

    return redirect()->route('security.dashboard')
    ->with('success', 'Capability verified successfully.');
}

public function dashboard()
{
    return view('security-dashboard');
}
}