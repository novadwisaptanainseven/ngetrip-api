<?php

use App\Http\Controllers\AgentTravelController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\TiketWisataController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Agent Travel
// Get All Agent Travel
Route::get('agent-travel', [AgentTravelController::class, 'getAll']);
// Get Agent Travel by Id
Route::get('agent-travel/{id_agent_travel}', [AgentTravelController::class, 'getById']);
// Insert Agent Travel
Route::post('agent-travel', [AgentTravelController::class, 'insert']);
// Edit Agent Travel
Route::put('agent-travel/{id_agent_travel}', [AgentTravelController::class, 'edit']);
// Delete Agent Travel
Route::delete('agent-travel/{id_agent_travel}', [AgentTravelController::class, 'delete']);

// Paket Wisata

// Get All Paket Wisata
Route::get('paket-wisata', [PaketWisataController::class, 'getAll']);
// Get All Paket Wisata berdasarkan Agent Travel
Route::get('agent-travel/{id_agent_travel}/paket-wisata', [PaketWisataController::class, 'getByAgentTravel']);
// Get Paket Wisata By Id
Route::get('paket-wisata/{id_paket_wisata}', [PaketWisataController::class, 'getById']);
// Insert Paket Wisata berdasarkan data agent travel
Route::post('agent-travel/{id_agent_travel}/paket-wisata', [PaketWisataController::class, 'insert']);
// Edit Paket Wisata
Route::put('paket-wisata/{id_paket_wisata}', [PaketWisataController::class, 'edit']);
// Delete Paket Wisata
Route::delete('paket-wisata/{id_paket_wisata}', [PaketWisataController::class, 'delete']);
// Insert Rating Wisata
Route::post('paket-wisata/{id_paket_wisata}/rating', [PaketWisataController::class, 'insertRating']);

// Deskripsi
// Get All Deskripsi Wisata
Route::get('paket-wisata/{id_paket_wisata}/deskripsi', [PaketWisataController::class, 'getDeskripsi']);
// Insert Deskripsi Wisata
Route::post('paket-wisata/{id_paket_wisata}/deskripsi', [PaketWisataController::class, 'insertDeskripsi']);
// Edit Deskripsi Wisata
Route::put('paket-wisata/{id_paket_wisata}/deskripsi/{id_deskripsi_wisata}', [PaketWisataController::class, 'editDeskripsi']);
// Delete Deskripsi Wisata
Route::delete('paket-wisata/{id_paket_wisata}/deskripsi/{id_deskripsi_wisata}', [PaketWisataController::class, 'deleteDeskripsi']);

// Include
// Get All Include Wisata
Route::get('paket-wisata/{id_paket_wisata}/include', [PaketWisataController::class, 'getInclude']);
// Insert Include Wisata
Route::post('paket-wisata/{id_paket_wisata}/include', [PaketWisataController::class, 'insertInclude']);
// Edit Include Wisata
Route::put('paket-wisata/{id_paket_wisata}/include/{id_include_wisata}', [PaketWisataController::class, 'editInclude']);
// Delete Include Wisata
Route::delete('paket-wisata/{id_paket_wisata}/include/{id_include_wisata}', [PaketWisataController::class, 'deleteInclude']);

// Exclude
// Get All Exclude Wisata
Route::get('paket-wisata/{id_paket_wisata}/exclude', [PaketWisataController::class, 'getExclude']);
// Insert Exclude Wisata
Route::post('paket-wisata/{id_paket_wisata}/exclude', [PaketWisataController::class, 'insertExclude']);
// Edit Exclude Wisata
Route::put('paket-wisata/{id_paket_wisata}/exclude/{id_exclude_wisata}', [PaketWisataController::class, 'editExclude']);
// Delete Exclude Wisata
Route::delete('paket-wisata/{id_paket_wisata}/exclude/{id_exclude_wisata}', [PaketWisataController::class, 'deleteExclude']);

// Gambar
// Get All Gambar
Route::get('paket-wisata/{id_paket_wisata}/gambar', [PaketWisataController::class, 'getGambar']);
// Insert Gambar
Route::post('paket-wisata/{id_paket_wisata}/gambar', [PaketWisataController::class, 'insertGambar']);
// Delete Gambar
Route::delete('paket-wisata/{id_paket_wisata}/gambar/{id_gambar}', [PaketWisataController::class, 'deleteGambar']);

// Tiket Wisata
// Get All Tiket Wisata
Route::get('tiket-wisata', [TiketWisataController::class, 'getAll']);
// Get Tiket Wisata By Id
Route::get('tiket-wisata/{id_tiket_wisata}', [TiketWisataController::class, 'getById']);
// Insert Tiket Wisata
Route::post('tiket-wisata', [TiketWisataController::class, 'insert']);
// Edit Tiket Wisata
Route::put('tiket-wisata/{id_tiket_wisata}', [TiketWisataController::class, 'edit']);
// Delete Tiket Wisata
Route::delete('tiket-wisata/{id_tiket_wisata}', [TiketWisataController::class, 'delete']);