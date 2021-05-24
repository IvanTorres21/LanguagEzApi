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
            $dictionary = Dictionary::select()->where('languages_id', $request->id)->get();
            return response()->json([
                'status_code' => 200,
                'dictionary' => $dictionary != null ? $dictionary : []
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve dictionary'
            ]);
        }
    }

    public function getWord($id) {
        try {
            $word = Dictionary::select()->where('id', $id)->first();
            return response()->json([
                'status_code' => 200,
                'word' => $word != null ? $word : []
            ]);
        }  catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve word'
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
            $word->og_word = $request->ogWord;
            $word->tr_word =  json_decode($request->trWord);
            $word->pr_word = $request->prWord;
            $word->languages_id = $request->id;
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
            $word->og_word = $request->ogWord;
            $word->tr_word =json_decode($request->trWord);
            $word->pr_word = $request->prWord;
            $word->save();
            return response([
                'status_code' => 200,
                'message' => 'Word saved correctly',
                'word' => $word
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
