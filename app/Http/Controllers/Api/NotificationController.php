<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    /**
     * Retrieves notifications
     */
    public function index(Request $request) {

        try {
            $notification = Notification::all();
            return response()->json([
                'status_code' => 200,
                'notifications' => $notification
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Couldn\'t retrieve notifications',
                'error' => $error
            ]);
        }
    }

    /**
     * Stores a notification
     */
    public function store(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $notification = new Notification;
            $notification->title = json_decode($request->title);
            $notification->content = json_decode($request->content);
            $notification->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Notification saved'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t save notifications'
            ]);
        }
    }

    /**
     * Updates a notification
     */
    public function update(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $notification = Notification::where('id', $request->id)->first();
            $notification->title = json_decode($request->title);
            $notification->content = json_decode($request->content);
            $notification->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Notification saved'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t update notification'
            ]);
        }
    }

    /**
     * Deletes a notification
     */
    public function delete(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $notification = Notification::where('id', $request->id)->first();
            $notification->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Notification deleted'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t delete notification'
            ]);
        }
    }
}
