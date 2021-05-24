<?php

namespace App\Http\Controllers\Api;

use App\Models\ExerciseTest;
use App\Models\ExerciseLesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

    /**
     * Gets exercises from lessons or tests
     */
    public function index(Request $request) {
        try {
            //If lesson is true we get the ExerciseLesson from lessons,
            //If lesson is false we get the ExerciseTest from tests
            //This repeats in every function on this controller
            $exercises;
            if($request->lesson == true) {
                $exercises = ExerciseLesson::where('languages_id', $request->id)->get(); 
            } else {
                $exercises = ExerciseTest::where('tests_id', $request->id)->get();
            }
            return response()->json([
                'status_code' => 200,
                'exercises' => $exercises
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve exercises'
            ]);
        }
    }

    public function getExercise(Request $request) {
        try {
            //If lesson is true we get the ExerciseLesson from lessons,
            //If lesson is false we get the ExerciseTest from tests
            //This repeats in every function on this controller
            $exercise;
            if($request->lesson == true) {
                $exercise = ExerciseLesson::where('id', $request->id)->first(); 
            } else {
                $exercise = ExerciseTest::where('id', $request->id)->first();
            }
            return response()->json([
                'status_code' => 200,
                'exercise' => $exercise
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve exercises'
            ]);
        }
    }

    /**
     * Creates a new Exercise
     * type	sentence	translation	og_word	correct_word	wrong_word	
     */
    public function store(Request $request) {
        try {
            if(!$request->user()->admin) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $exercise;
            if($request->lesson == true) {
                $exercise = new ExerciseLesson;
                $exercise->lesson_id = $request->id;
            } else {
                $exercise = new ExerciseTest;
                $exercise->tests_id = $request->id;
            }
            $exercise->type = $request->type;
            $exercise->sentence = $request->sentence;
            $exercise->translation = $request->translation;
            $exercise->og_word = $request->og_word;
            $exercise->correct_word = $request->correct_word;
            $exercise->wrong_word = $request->wrong_word;
            $exercise->save();
            return response()->json([
                'status_code' => 200,
                'exercise' => $exercise
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t store exercise'
            ]);
        }
    }

    /**
     * Updates a exercise
     */
    public function update(Request $request) {
        try {
            if(!$request->user()->admin) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $exercise;
            if($request->lesson == true) {
                $exercise = ExerciseLesson::where('id', $request->id)->first();
            } else {
                $exercise = ExerciseTest::where('id', $request->id)->first();
            }
            $exercise->type = $request->type;
            $exercise->sentence = $request->sentence;
            $exercise->translation = $request->translation;
            $exercise->og_word = $request->og_word;
            $exercise->correct_word = $request->correct_word;
            $exercise->wrong_word = $request->wrong_word;
            $exercise->save();
            return response()->json([
                'status_code' => 200,
                'exercise' => $exercise
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t update exercise'
            ]);
        }
    }

    /**
     * deletes an exercise
     */
    public function delete(Request $request) {
        try {
            if(!$request->user()->admin) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $exercise;
            if($request->lesson == true) {
                $exercise = ExerciseLesson::where('id', $request->id)->first();
            } else {
                $exercise = ExerciseTest::where('id', $request->id)->first();
            }
            $exercise->delete();
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t update exercise'
            ]);
        }
    }
}
