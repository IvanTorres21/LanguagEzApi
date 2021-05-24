<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Returns all badges.
     */
    public function index() {
        $badges = Badge::all();
        return response()->json($badges, 200);
    }

    /**
     * Returns all badges and marks those that 
     * belong to the user with user_id.
     */
    public function userBadges(Request $request) {
        try {
            $userBadges = UserBadge::select('badge_id')->where('user_id', $request->user_id)->get();
            $badgesOwned = [];
            foreach($userBadges as $badge) {
                $badge_id = $badge->toArray()['badge_id'];
                array_push($badgesOwned, $badge_id);
            }
            $badges = Badge::all();
            $result = [];
            foreach($badges as $badge) {
                if(in_array($badge->id, $badgesOwned)) {
                    $badge['unlocked'] = true;
                } else {
                    $badge['unlocked'] = false;
                }
                $badge = $badge->toArray();
                array_push($result, $badge);
            }
            return response()->json([
                'status_code' => 200,
                'data' => $result
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error
            ]);
        }
    }

    /**
     * Retrieves the data from a badge
     */
    public function getBadge(Request $request) {
        try {
            $badge = Badge::findFirst($request->$id);
            return response()->json([
                'status_code' => 500,
                'badge' => $badge
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error
            ]);
        }
    }

    /**
     * Updates an already existing badge
     */
    public function update(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $badge = Badge::where('id', $request->id)->first();
            $badge->name = json_decode($request->name);
            $badge->description = json_decode($request->description);
            $badge->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Badge updated correctly'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error
            ]);
        }
    }

    /**
     * Creates a new Badge
     */
    public function store(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $badge = new Badge;
            $badge->name = json_decode($request->name);
            $badge->description = json_decode($request->description);
            $badge->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Badge stored successfully'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error
            ]);
        }
    }

    /**
     * Assign a badge to an user
     */
    public function assignBadge(Request $request) {
        try {
            $user = $request->user();
            $userBadge = new UserBadge;
            $userBadge->user_id = $user->id;
            $userBadge->badge_id = $request->badge_id;
            $userBadge->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Assigned badge correctly'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error
            ]);
        }
    }

    /**
     * Deletes a badge
     */
    public function deleteBadge(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $badge = Badge::findOrFail($request->id);
            $badge->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Deleted badge'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t delete badge'
            ]);
        }
    }
}

