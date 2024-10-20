<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class UserController extends Controller
{
    // Mengaktifkan Otentikasi Dua Faktor
    public function enableTwoFactorAuth(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        // Menghasilkan secret key untuk pengguna
        $secretKey = $google2fa->generateSecretKey();
        $user->two_factor_secret = encrypt($secretKey);
        $user->save();

        // Menghasilkan URL QR Code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'), // Nama aplikasi
            $user->email, // Email pengguna
            $secretKey // Secret key yang dihasilkan
        );

        return view('2fa.qr_code', compact('qrCodeUrl', 'secretKey'));
    }

    // Memverifikasi Kode OTP
    public function verifyTwoFactorAuth(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        $secretKey = decrypt($user->two_factor_secret); // Mendapatkan secret key
        $valid = $google2fa->verifyKey($secretKey, $request->input('one_time_password')); // Verifikasi kode OTP

        if ($valid) {
            // Login berhasil
            return redirect('/home')->with('success', 'Logged in successfully!');
        } else {
            return back()->withErrors(['one_time_password' => 'Invalid OTP.']);
        }
    }
}
