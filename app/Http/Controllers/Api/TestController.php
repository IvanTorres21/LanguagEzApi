<?php

namespace App\Http\Controllers\Api;

use App\Models\Lesson;
use App\Models\UserTest;
use App\Models\Language;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    
    /**
     * Get all the tests a language has.
     */
    public function index(Request $request) {
        try {
            $lessons = Language::where('id', $request->id)->with('tests')->first();
            return response()->json([
                'status_code' => 200,
                'lessons' => $lessons
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve tests'
            ]);
        }
    }

    /**
     * Stores a new test
     */
    public function store(Request $request) {
        try {
            if(!$request->user()->admin) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $test = new Test;
            $test->name = json_decode($request->name);
            $test->languages_id = $request->language_id;
            $test->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Test created succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t store test'
            ]);
        }
    }

    /**
     * Updates a test
     */
    public function update(Request $request) {
        try {
            if(!$request->user()->admin) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $test = Test::where('id', $request->id)->first();
            $test->name = json_decode($request->name);
            $test->languages_id = $request->language_id;
            $test->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Test updated succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t update test'
            ]);
        }
    }

    /**
     * Get a test
     */
    public function getLesson(Request $request) {
        try {
            $test = Test::where('id', $request->id)->with('exercises')->first();
            return response()->json([
                'status_code' => 200,
                'message' => 'Test retrieved succesfully',
                'lesson' => $test
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve test'
            ]);
        }
    }

    /**
     * Deletes a test
     */
    public function delete(Request $request) {
        try {
            if(!$request->user()->admin) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $test = Test::where('id', $request->id)->first();
            $test->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Test deleted succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t delete test'
            ]);
        }
    }

    /**
     * Marks a test as done with the score
     */
    public function markTestAsDone(Request $request) {
        try {
            $userTest = UserTest::where([['users_id', '=', $request->user()->id], ['tests_id', '=', $request->test_id]])->get();
            if($userTest->count() == 0) {
                $userTest = new UserTest;
                $userTest->users_id = $request->user()->id;
                $userTest->tests_id = $request->test_id;
                $userTest->score = $request->score;
            } else {
                $userTest = $userTest[0];
                $userTest->score = $request->score;
            }
            $userTest->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Test marked succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t mark test'
            ]);
        }
    }
}
