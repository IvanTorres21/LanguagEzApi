<?php

namespace App\Http\Controllers\Api;

use App\Models\Lesson;
use App\Models\Language;
use App\Models\UserLanguage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Get lessons from language
     */
    public function index(Request $request) {
        try {
            $lessons = Language::where('id', $request->id)->with('lessons')->get();
            return response()->json([
                'status_code' => 200,
                'language' => $lessons
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve lessons'
            ]);
        }
    }

    /**
     * Stores a lesson
     */
    public function store(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $lesson = new Lesson;
            $lesson->title = json_decode($request->title);
            $lesson->theory = json_decode($request->theory);
            $lesson->languages_id = $request->id;
            $lesson->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Lesson saved succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t save lesson'
            ]);
        }
    }

    /**
     * Updates a lesson
     */
    public function update(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $lesson = Lesson::where('id', $request->id)->first();
            $lesson->title = json_decode($request->title);
            $lesson->theory = json_decode($request->theory);
            $lesson->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Lesson updated succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t update lesson'
            ]);
        }
    }

    /**
     * Deletes a lesson
     */
    public function delete(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $lesson = Lesson::where('id', $request->id)->first();
            $lesson->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Lesson deleted succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t delete lesson'
            ]);
        }
    }

    /**
     * Marks lessons as done, this is to keep track of what lesson they are doing 
     * and what tests they should have access to.
     */
    public function markLessonAsDone(Request $request) {
        try {
            $lesson = Lesson::where('id', $request->id)->first();
            $userLanguage = UserLanguage('users_id', $request->user()->id)->where('languages_id', $lesson->languages_id)->first();
            $userLanguage->lessons_done = $userLanguage->lessons_done + 1;
            $userLanguage->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Lesson marked as done succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t mark lesson'
            ]);
        }
    }
}
