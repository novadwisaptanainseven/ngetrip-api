<?php

use App\Http\Controllers\AgentTravelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\TiketWisataController;
use App\Http\Controllers\WishlistController;
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


Route::group(["middleware" => "auth:sanctum"], function () {

  // Dashboard
  // Get Dashboard Information
  Route::get('dashboard', [DashboardController::class, 'getDashboardInformation']);

  // Agent Travel
  // Get All Agent Travel
  Route::get('agent-travel', [AgentTravelController::class, 'getAll']);
  // Get Agent Travel by Id
  Route::get('agent-travel/{id_agent_travel}', [AgentTravelController::class, 'getById']);
  // Insert Agent Travel
  Route::post('agent-travel', [AgentTravelController::class, 'insert']);
  // Edit Agent Travel
  Route::post('agent-travel/{id_agent_travel}', [AgentTravelController::class, 'edit']);
  // Delete Agent Travel
  Route::delete('agent-travel/{id_agent_travel}', [AgentTravelController::class, 'deleteAgentTravel']);

  // Kontak Agent Travel
  // Get All Kontak
  Route::get("agent-travel/{id_agent_travel}/kontak", [AgentTravelController::class, 'getAllKontak']);
  // Get Kontak By ID
  Route::get("agent-travel/{id_agent_travel}/kontak/{id_kontak}", [AgentTravelController::class, 'getKontakById']);
  // Insert Kontak
  Route::post("agent-travel/{id_agent_travel}/kontak", [AgentTravelController::class, 'insertKontak']);
  // Edit Kontak
  Route::put("agent-travel/{id_agent_travel}/kontak/{id_kontak}", [AgentTravelController::class, 'editKontak']);
  // Delete Kontak
  Route::delete("agent-travel/{id_agent_travel}/kontak/{id_kontak}", [AgentTravelController::class, 'deleteKontak']);

  // Paket Wisata

  // Get All Paket Wisata
  Route::get('paket-wisata', [PaketWisataController::class, 'getAll']);
  // Get All Paket Wisata berdasarkan Agent Travel
  Route::get('agent-travel/{id_agent_travel}/paket-wisata', [PaketWisataController::class, 'getByAgentTravel']);
  // Get Paket Wisata By Id
  Route::get('paket-wisata/{id_paket_wisata}', [PaketWisataController::class, 'getById']);
  // Insert Paket Wisata berdasarkan data agent travel
  Route::post('agent-travel/{id_agent_travel}/paket-wisata', [PaketWisataController::class, 'insert']);
  // Insert Paket Wisata
  Route::post('paket-wisata', [PaketWisataController::class, 'insertPaketWisata']);
  // Edit Paket Wisata
  Route::put('paket-wisata/{id_paket_wisata}', [PaketWisataController::class, 'edit']);
  // Delete Paket Wisata
  Route::delete('paket-wisata/{id_paket_wisata}', [PaketWisataController::class, 'delete']);
  // Insert Rating Wisata
  Route::post('paket-wisata/{id_paket_wisata}/rating', [PaketWisataController::class, 'insertRating']);

  // Deskripsi
  // Get All Deskripsi Wisata
  Route::get('paket-wisata/{id_paket_wisata}/deskripsi', [PaketWisataController::class, 'getDeskripsi']);
  // Get Deskripsi Wisata by ID
  Route::get('paket-wisata/{id_paket_wisata}/deskripsi/{id_deskripsi}', [PaketWisataController::class, 'getDeskripsiById']);
  // Insert Deskripsi Wisata
  Route::post('paket-wisata/{id_paket_wisata}/deskripsi', [PaketWisataController::class, 'insertDeskripsi']);
  // Edit Deskripsi Wisata
  Route::put('paket-wisata/{id_paket_wisata}/deskripsi/{id_deskripsi_wisata}', [PaketWisataController::class, 'editDeskripsi']);
  // Delete Deskripsi Wisata
  Route::delete('paket-wisata/{id_paket_wisata}/deskripsi/{id_deskripsi_wisata}', [PaketWisataController::class, 'deleteDeskripsi']);

  // Include
  // Get All Include Wisata
  Route::get('paket-wisata/{id_paket_wisata}/include', [PaketWisataController::class, 'getInclude']);
  // Get Include Wisata By ID
  Route::get('paket-wisata/{id_paket_wisata}/include/{id_include}', [PaketWisataController::class, 'getIncludeById']);
  // Insert Include Wisata
  Route::post('paket-wisata/{id_paket_wisata}/include', [PaketWisataController::class, 'insertInclude']);
  // Edit Include Wisata
  Route::put('paket-wisata/{id_paket_wisata}/include/{id_include_wisata}', [PaketWisataController::class, 'editInclude']);
  // Delete Include Wisata
  Route::delete('paket-wisata/{id_paket_wisata}/include/{id_include_wisata}', [PaketWisataController::class, 'deleteInclude']);

  // Exclude
  // Get All Exclude Wisata
  Route::get('paket-wisata/{id_paket_wisata}/exclude', [PaketWisataController::class, 'getExclude']);
  // Get Exclude Wisata by ID
  Route::get('paket-wisata/{id_paket_wisata}/exclude/{id_exclude}', [PaketWisataController::class, 'getExcludeById']);
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
  // Update Status Gambar
  Route::put('paket-wisata/{id_paket_wisata}/gambar/{id_gambar}/status', [PaketWisataController::class, 'updateStatusGambar']);

  // Tiket Wisata
  // Get All Tiket
  Route::get('tiket-wisata', [TiketWisataController::class, 'getAll']);
  // Get Tiket Wisata by Username
  Route::get('tiket-wisata/username/{username}', [TiketWisataController::class, 'getByUsername']);
  // Get Tiket Wisata By Id
  Route::get('tiket-wisata/{id_tiket_wisata}', [TiketWisataController::class, 'getById']);
  // Insert Tiket Wisata
  Route::post('tiket-wisata', [TiketWisataController::class, 'insert']);
  // Edit Tiket Wisata
  Route::put('tiket-wisata/{id_tiket_wisata}', [TiketWisataController::class, 'edit']);
  // Delete Tiket Wisata
  Route::delete('tiket-wisata/{id_tiket_wisata}', [TiketWisataController::class, 'deleteTiket']);

  // Wishlist
  // Insert Wishlist
  Route::post('wishlist', [WishlistController::class, "insert"]);
  // Get All Wishlist
  Route::get('wishlist/username/{username}', [WishlistController::class, "getByUsername"]);
  // Get Wishlist by Id Paket Wisata and Username
  Route::get('wishlist/{id_paket_wisata}', [WishlistController::class, "getByIdPaketWisata"]);
  // Delete Wishlist by Id Paket Wisata
  Route::delete('wishlist/{id_paket_wisata}', [WishlistController::class, "deleteWishlist"]);
});

// Login
Route::post("login", [AuthController::class, "login"]);

// Register
Route::post("register", [AuthController::class, "register"]);

// Cek user saat ini
Route::middleware("auth:sanctum")->get("user", [AuthController::class, "me"]);

// Logout
Route::middleware("auth:sanctum")->post("logout", [AuthController::class, "logout"]);

// Update User By ID
Route::middleware("auth:sanctum")->put("update-user/{id_user}", [AuthController::class, "updateUser"]);

// Download File Gambar
Route::get("file/{path}/{filename}", [FileController::class, "getImage"]);

// Token API
// Bearer 1|gAzCT25KQ6TtKuuMASm8xwaFJeAjgIKS3MWNFOXu
