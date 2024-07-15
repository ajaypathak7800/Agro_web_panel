<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Master;
use App\Models\cbbo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{

    //acheck the login token 
    /**
     * Check API Authentication
     *
     * This method checks if the provided API token is valid by looking up the user
     * associated with the token. If a user is found, it returns true, otherwise false.
     *
     * @param \Illuminate\Http\Request $data
     * @return bool
     */
    public function checkApiAuth($data)
    {
        if ($data->api_token) {
            // Check if a user with the provided api_token exists
            $user = User::where('api_token', $data->api_token)->first();

            // Return true if a user is found, otherwise, return false
            return !is_null($user);
        } else {
            // If api_token is not provided, return false
            return false;
        }
    }

    public function master(Request $request)
    {
        $response = array();
        $validator = Validator::make(
            $request->all(),
            array(
                'api_token' => 'required',
            )
        );

        if ($validator->fails()) {
            $response['flag'] = false;
            $response['errors'] = $this->parseErrorResponse($validator->getMessageBag());
        } else {
            if ($this->checkApiAuth($request)) {
                try {
                    // Use Eloquent to get distinct values from 'implementing_agency' column
                    $master = DB::table('master')->get();

                    $response['status'] = 1;
                    $response['data'] = $master;
                } catch (\Exception $e) {
                    $response['status'] = 0;
                    $response['message'] = $e->getMessage();
                }
            } else {
                $response['status'] = 0;
                $response['message'] = "Session Expired";
                $response['is_token_expired'] = 1;
            }
        }

        return response()->json($response);
    }

    //cbbo_expert
    public function cbbo(Request $request)
    {
        $response = array();
        $validator = Validator::make(
            $request->all(),
            array(
                'api_token' => 'required',
            )
        );

        if ($validator->fails()) {
            $response['flag'] = false;
            $response['errors'] = $this->parseErrorResponse($validator->getMessageBag());
        } else {
            if ($this->checkApiAuth($request)) {
                try {
                    // Use Eloquent to get distinct values from 'implementing_agency' column
                    $master = DB::table('cbbo_experts')->get();

                    $response['status'] = 1;
                    $response['data'] = $master;
                } catch (\Exception $e) {
                    $response['status'] = 0;
                    $response['message'] = $e->getMessage();
                }
            } else {
                $response['status'] = 0;
                $response['message'] = "Session Expired";
                $response['is_token_expired'] = 1;
            }
        }

        return response()->json($response);
    }
}
