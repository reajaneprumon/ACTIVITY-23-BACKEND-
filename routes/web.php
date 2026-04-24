<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

Route::get('/email/verify/{id}/{hash}', function ($id, $hash, Request $request) {

    if (! URL::hasValidSignature($request)) {
        abort(403, 'Invalid or expired verification link.');
    }

    $user = User::find($id);

    if (!$user) {
        abort(404, 'User not found.');
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect('http://127.0.0.1:5500/Frontend/login.html');

})->name('verification.verify');