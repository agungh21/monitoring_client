<?php

use App\Models\MonitoringClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-monitoring-client', function (Request $request) {
    
    if($request->pass == "simpan"){
        \DB::beginTransaction();
        try {
            MonitoringClient::createMonitoringClient($request->all());
            \DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Data Monitoring Client Berhasil', 'status_code' => 200]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'status_code' => 500]);
        }
    }

    return response()->json(['status' => 'error', 'message' => 'Your Dont Have Permission', 'status_code' => 403]);

});
