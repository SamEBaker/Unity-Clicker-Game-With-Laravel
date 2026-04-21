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
    $newUser = false;

    // AUTO REGISTER if not exists
    if (!$user) {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'score' => 0,
            'high_score' => 0,
            'sprite' => 0,
        ]);
        $newUser = true;
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
        'user' => $user,
        'newUser' => $newUser
    ]);
}
    public function leaderboard()
    {
        $users = User::orderBy('high_score', 'score', 'desc')
            ->limit(10)
            ->get(['username', 'score', 'high_score']);

        return response()->json([
            'items' => $users
        ]);
    }
    public function saveScore(Request $request)
    {
        $user = $request->user();

        // update current score
        //$user->score = $request->score;

        // update high score
        if ($request->score > $user->high_score) {
            $user->high_score = $request->score;
        }

        $user->save();

        return response()->json([
            'status' => 'Success',
            'score' => $user->score,
            'high_score' => $user->high_score
        ]);
    }
        
    
    //saving sprite upgrade index
    public function saveSprite(Request $request)
    {
        $request->validate([
            'sprite' => 'required|integer'
        ]);

    $user = $request->user();
    $user->sprite = $request->sprite; 
    $user->save();

        return response()->json([
            'status' => 'Success',
            'sprite' => $user->sprite
        ]);
    }
}
 