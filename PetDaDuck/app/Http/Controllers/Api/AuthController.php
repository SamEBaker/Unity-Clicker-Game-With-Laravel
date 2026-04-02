<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid login'], 401);
        }

        $token = $user->createToken('unity-game-token')->plainTextToken; 

        return response()->json([
            'token' => $token,
            'user'  => $user
        ]);
    }

    public function saveScore(Request $request)
    {
        $user = $request->user();
        $user->score = $request->score; // DB 'score' column
        $user->save();

        return response()->json(['status' => 'Success', 'new_score' => $user->score]);
    }
}
 