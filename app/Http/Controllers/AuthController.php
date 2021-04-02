<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;

    // Login 
    public function login(Request $request)
    {
        // Request Validation
        $messages = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "username" => "required",
                "password" => "required"
            ],
            $messages
        );
        // Validation Check
        if ($validator->fails()) {
            // Jika validasi gagal
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // Jika validasi berhasil
        $user = User::where("username", "=", $request->username)->first();

        // Cek apakah username salah / tidak ditemukan
        if (!$user) {
            return response()->json([
                "message" => "Username salah"
            ], 400);
        }
        // Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Password salah"
            ], 400);
        }

        // Jika semua validasi terlewati
        // Buat token
        $token = $user->createToken($user->username)->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token
        ];

        return response($response, 201);
    }

    // Register
    public function register(Request $request)
    {
        // Validation
        $messages = [
            "required" => ":attribute harus diisi",
            "unique" => ":attribute sudah ada yang punya"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:users',
                'password' => 'required',
                'name'     => 'required',
            ],
            $messages
        );
        // Jika Validasi Gagal
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        // Jika validasi berhasil
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "message" => "Register user berhasil",
            "input_data" => $user
        ], 201);
    }

    // Cek user saat ini
    public function me()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                "message" => "Authenticated",
                "user"    => $user
            ], 200);
        } else {
            return response()->json([
                "message" => "User belum login"
            ], 200);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logout Success",
            "user"    => $request->user()
        ]);
    }

    // Update User
    public function updateUser(Request $request, $id_user)
    {
        // Cek username
        $user = User::where("id", "=", $id_user)->first();
        if ($user->username === $request->username) {
            $username_rules = 'required';
        } else {
            $username_rules = 'unique:users|required';
        }

        // Cek password baru
        if ($request->password_baru) {
            $password_lama_rules = "required";
        } else {
            $password_lama_rules = "";
        }

        // Validation
        $message = [
            "required" => ":attribute harus diisi",
            "unique" => ":attribute sudah ada yang punya"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "name"          => 'required',
                "username"      => $username_rules,
                "password_lama" => $password_lama_rules,
            ],
            $message
        );
        if ($validator->fails()) {
            // Jika Validasi Gagal
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        if ($request->password_baru) {
            // Cek password lama
            if (!Hash::check($request->password_lama, $user->password)) {
                return response([
                    'errors' => ['Password lama salah']
                ], 400);
            }

            // Cek apakah konfirmasi password cocok
            if ($request->password_baru === $request->konf_password) {
                // Hashing password
                $password_baru = Hash::make($request->password_baru);
            } else {
                return response([
                    'errors' => ['Konfirmasi password tidak sesuai']
                ], 400);
            }
        }

        // Jika Validasi Berhasil
        // Lakukan Update Data

        $user->username = ($request->username !== null) ? $request->username : $user->username;
        $user->name = ($request->name !== null) ? $request->name : $user->name;
        if ($request->password_baru) {
            $user->password = $password_baru;
        }
        $user->save();

        return response()->json([
            "message" => "Update Data User with id: $id_user, Success",
            "data"    => $user
        ]);
    }
}
