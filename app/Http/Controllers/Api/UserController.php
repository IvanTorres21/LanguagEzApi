<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * Logins an already existing user.
     */
    public function login(Request $request) {

        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $user = User::where('email', $request->email)->first();
            if (! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

              
            $tokenResult = $user->createToken('authToken')->plainTextToken;            

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    /**
     * Creates a new user.
     */
    public function signUp(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $userData = $request;
            $userData['points'] = 0;
            $userData['level'] = 0;
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);;
            $user->points = 0;
            $user->level = 0;
            $user->save();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);

        } catch  (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Signup',
                'error' => $error,
            ]);
        }
    }

    /**
     * Adds a friend to the logged user using
     * an email to identify them
     */
    public function addFriend(Request $request){
        try {
            $userFriend = User::where('email', $request->email)->first();
            $friend = new Friend;
            $friend->user_id = $request->user()->id;
            $friend->friend_id = $userFriend->id;
            if(!empty(Friend::where([['user_id', '=', $friend->user_id], ['friend_id', '=', $friend->friend_id]])->first())) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Friend already added!'
                ]);
            }
            $friend->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Friend added successfully'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error adding friend',
                'error' => $error,
            ]);
        }
    }

    /**
     * Retrieves user friends
     */
    public function getfriends(Request $request) {
        try {

            $user = $request->user();
            
            $friends = Friend::where('user_id', $user->id)->with('user')->get();

            return response()->json([
                "status_code" => 200,
                'data' => $friends
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error retrieving friends',
                'error' => $error
            ]);
        }
    }

    /**
     * deletes friends
     */
    public function deleteFriend(Request $request) {
        try {
            $friend = Friend::where('user_id', $request->user()->id)->where('friend_id', $request->friend_id)->first();
            $friend->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Friend deleted successfully'
            ]);            
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error retrieving friends',
                'error' => $error
            ]);
        }
    }

    /**
     * Get user profile
     */
    public function getProfile(Request $request) {
        try {
            $user = $request->user();
            return response()->json([
                'status_code' => 200,
                'user' => $user
            ]);        
        }
        catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error retrieving friends',
                'error' => $error
            ]);
        }
    }
}
