<?php

namespace App\Http\Controllers\Api;

use App\Models\Lesson;
use App\Models\Language;
use App\Models\UserLanguage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    
    /**
     * Function that retrieves all the languages
     */
    public function index(Request $request) {
        try {

            $languages;
            if($request->user()->admin) {
                $languages = Language::all();
            } else {
                $languages = Language::where('visible', true)->get();
            }
            $result = [];
            $assigned = UserLanguage::select('languages_id')->where('users_id', $request->user()->id)->get()->toArray();
            $aux = [];
            foreach($assigned as $assign) {
                $helper = $assign['languages_id'];
                array_push($aux, $helper);
            }
            // If the language has been assigned to the User we make sure to tell the app
            foreach($languages as $language) {
                if(in_array($language->id, $aux)) {
                    $language['assigned'] = true;
                } else {
                    $language['assigned'] = false;
                }
                array_push($result, $language);
            }
            return response()->json([
                'status_code' => 200,
                'message' => 'Languages retrieved',
                'languages' => $result
            ]);
        } catch (Exception $error) {

            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve languages'
            ]);
        }
    }

    public function getLanguage($id) {
        try {
            $language = Language::findOrFail($id);
            return response()->json([
                'status_code' => 200,
                'message' => 'Language retrieved',
                'language' => $language
            ]);
        } catch (Exception $error) {

            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve language'
            ]);
        }
    }

    /**
     * Function that updates a Language
     */
    public function update(Request $request) {
        try {

            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Unauthorized'
                ]);
            }
            $language = Language::where('id', $request->id)->first();
            $language->name = json_decode($request->name);
            $language->image = $request->image;
            $language->visible = $request->visible;
            $language->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Language updated succesfully'
            ]);
        } catch(Exception $error) {
            return reponse()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieve lessons'
            ]);
        }
    }

    /**
     * Function that stores a new language
     */
    public function store(Request $request) {
        try {

            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $language = new Language;
            $language->name = json_decode($request->name);
            $language->image = $request->image;
            $language->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Language created succesfully'
            ]);
        } catch(Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t create language'
            ]);
        }
    }

    /**
     * Gets all lessons from a language, and marks
     * those that have been done by the user
     */
    public function getLessons(Request $request) {
        try {

            $language = Language::where('id', $request->id)->first();
            $language['lessons'] = Lesson::where('languages_id', $language->id)->get();
            return response()->json([
                'status_code' => 200,
                'message' => 'Lessons retrieved',
                'language' => $language
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t retrieved lessons'
            ]);
        }
    }

    /**
     * Assings a language to an user
     */
    public function assignLanguage(Request $request) {
        try {

            $userLanguage = new UserLanguage;
            $userLanguage->users_id = $request->user()->id;
            $userLanguage->languages_id = $request->id;
            $userLanguage->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Assigned language'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t assign language'
            ]);
        }
    }

    public function deleteLanguage(Request $request) {
        try {
            if($request->user()->admin == false) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
            $language = Language::findOrFail($request->id);
            $language->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Deleted language'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Couldn\'t delete language'
            ]);
        }
    }
}
