<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','string','email'],
            'password' => ['required','string'],
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = Str::random(128);
            $validThru = now()->addMonth();
            $this->removeUserTokens($user->id);
            DB::statement("INSERT INTO api_tokens (user_id, token, valid_thru) VALUES ({$user->id}, '{$token}', '{$validThru}');");
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }
    }

    public function logout()
    {
        $user = auth()->user();
        $this->removeUserTokens($user->id);
        return ['message' => 'Logged out successfully.'];
    }

    protected function removeUserTokens($userId)
    {
        DB::statement("DELETE FROM api_tokens WHERE user_id = {$userId};");
    }
}
