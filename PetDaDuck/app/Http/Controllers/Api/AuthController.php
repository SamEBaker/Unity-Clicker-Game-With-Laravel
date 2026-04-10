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
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();

    // AUTO REGISTER if not exists
    if (!$user) {
        $user = User::create([
            'username' => $request->username,
            'name' => $request->username, // optional display name
            'password' => Hash::make($request->password),
            'score' => 0,
            'sprite' => 0,
        ]);
    }

    // CHECK PASSWORD
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid login'
        ], 401);
    }

    $token = $user->createToken('unity-game-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}
    public function leaderboard()
    {
        $users = User::orderBy('score', 'desc')
            ->limit(10)
            ->get(['username', 'score']);

        return response()->json([
            'items' => $users
        ]);
    }
    public function saveScore(Request $request)
    {
        $user = $request->user();
        $user->score = max($user->score, $request->score); //saves highest score
        $user->save();

        return response()->json(['status' => 'Success', 'new_score' => $user->score]);
    }
    //create function for saving sprite selection
    public function saveSprite(Request $request)
{
    $request->validate([
        'sprite' => 'required|integer'
    ]);

    $user = $request->user();
    $user->sprite = $request->sprite; // make sure column exists!!!!
    $user->save();

    return response()->json([
        'status' => 'Success',
        'sprite' => $user->sprite
    ]);
}
}
 