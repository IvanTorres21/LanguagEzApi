<?php

namespace App\Http\Controllers\Api;

use App\Models\Dictionary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    
    /**
     * Gets all words of a language
     */
    public function index(Request $request) {
        try {
            $dictionary = Dictionary::select('og_word, tr_word, pr_word, languages_id')->where('languages_id', $request->id)->first();
            return response()->json([
                'status_code' => 200,
                'dictionary' => $dictionary
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve dictionary'
            ]);
        }
    }

    /**
     * Stores a new Word
     */
    public function store(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $word = new Dictionary;
            $word->og_word = $request->og_word;
            $word->tr_word = $request->tr_word;
            $word->pr_word = $request->pr_word;
            $word->save();
            return response([
                'status_code' => 200,
                'message' => 'Word saved correctly'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t store new word'
            ]);
        }
    }

    /**
     * Updates a word
     */
    public function update(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $word = Dictionary::where('id', $request->id)->first();
            $word->og_word = $request->og_word;
            $word->tr_word = $request->tr_word;
            $word->pr_word = $request->pr_word;
            $word->save();
            return response([
                'status_code' => 200,
                'message' => 'Word saved correctly'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t update word'
            ]);
        }
    }

    /**
     * Removes a word
     */
    public function destroy(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $word = Dictionary::where('id', $request->id)->first();
            $word->delete();
            return response([
                'status_code' => 200,
                'message' => 'Word deleted correctly'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t delete word'
            ]);
        }
    }
}
