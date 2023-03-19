<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /*Postulante: Danilo Andrés Carrión Lava */

    /*Endpoint para el inicio de sesión*/
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => array('required', 'string', 'email', 'max:255'),
            'password' => array('required', 'string', 'min:8'),
        ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 401);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Correo o contraseña incorrectos',
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ], 200);
    }

    /*Endpoint para registrar un usuario */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => array('required', 'string', 'max:255'),
                'last_name' => array('required', 'string', 'max:255'),
                'email' => array('required', 'string', 'email', 'unique:users', 'max:255'),
                'password' => array('required', 'string', 'min:8'),
                'birthdate' => array('required', 'date'),

            ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 401);
        }

        $user = User::create($request->all());

        $this->generateJsonAWS($user);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
        ], 201);

    }


    public function generateJsonAWS(User $user)
    {
        try {
            $data = [
                'name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'birthdate' => $user->birthdate,
            ];

            $json = json_encode($data);

            $fileName = 'user_' . $user->id . '.json';

            $upload = Storage::disk('s3')->put($fileName, $json);

            return $upload;

        } catch (\Exception$e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /*endpoint para restablecer contraseña */
    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'El correo ingresado no se encuentra registrado',
            ], 404);
        }
        $newPassword = Str::random(10);
        $fullName = $user->name . ' ' . $user->last_name;
        
        $user->password = Hash::make($newPassword);
       
        $user->save();

        Mail::to($user->email)->send(new ResetPasswordMail($newPassword, $fullName));
       
        return response()->json([
            'message' => 'Se ha enviado un correo con la nueva contraseña',
        ], 200);
    }

}
