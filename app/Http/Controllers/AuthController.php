<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        // Prvo validacija inputa i kreiranje niza fields
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email', // mora biti unique po users tabeli email koloni
            'password' => 'required|string|confirmed'  // confirmed znači da se mora poslati i password_confirmation polje
        ]);

        // Kreiranje usera u bazi
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        // User model sada ima createToken metodu za kreiranje tokena, argument je bilo šta
        $token = $user->createToken('pizza66')->plainTextToken;  // Vraća instancu Laravel\Sanctum\NewAccessToken

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    public function login(Request $request) 
    {
        // Prvo validacija inputa i kreiranje niza fields
        $fields = $request->validate([
            'email' => 'required|string', // mora biti unique po users tabeli email koloni
            'password' => 'required|string'  // confirmed znači da se mora poslati i password_confirmation polje
        ]);

        // Prvo pronalazi usera na osnovu email-a, ako postoji / first() umesto get() da odma vrati objekat a ne niz
        $user = User::where('email', $fields['email'])->first();

        // ako nije nasao usera ili ako se password ne poklapa vraca 401
        // Hash::check($fields['password'], $user->password) - Vraća 1 ako se poklapaju, 0 ako se NE poklapaju
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }

        // Kreira novi token isto kao i prilikom register
        $token = $user->createToken('pizza66')->plainTextToken;  // Vraća instancu Laravel\Sanctum\NewAccessToken

        $response = [
            'user' => $user,
            'token' => $token
        ];
        // Vraća usera i token
        return response($response, 201);
    }

    public function logout()
    {
        // pronalazi sve tokene usera i briše ih
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
