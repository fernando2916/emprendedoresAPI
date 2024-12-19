<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroRequest;
use App\Mail\PasswordResetEmail;
use App\Mail\ResetVerifyCodeMail;
use App\Mail\VerificationMail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(RegistroRequest $request) {
        $expiration = now()->addMinutes(15);

        $data = $request->validated();

        // Crear al usuario
        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verification_code' => random_int('100000', '999999'),
            'verification_code_expires_at' => $expiration,
            'verification_id' => Str::uuid(),
        ]);

        Mail::to($user->email)->send(new VerificationMail($user));

        return response()->json([
            'message' => 'Usuario registrado correctamente. Por favor, revisa tu correo y sigue las intrucciones.',

        ], 201);
        
    }

    public function verify(Request $request, $id) {

        $request->validate([
            'verification_code' => 'digits:6|required'
        ]);

        $user = User::where('verification_id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Código de verificación inválido.'], 400);
        }

        if (now()->greaterThan($user->verification_code_expires_at)) {
            return response()->json(['message' => 'El código de verificación ha expirado.'], 400);
        }

        $user->is_verified = 'verificado';
        $user->email_verfied_at = now();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Correo electrónico verificado exitosamente',
            'token' => $token,
        ], 200);
    }

    public function reset_code(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = $validator->validate();

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No se encontró el usuario'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'La cuenta ya está verificada'], 400);
        }

        $user->verification_code = rand(100000, 999999);
        $user->verification_code_expires_at = now()->addMinutes(15);
        $user->save();
    
        Mail::to($user->email)->send(new ResetVerifyCodeMail($user));
    
        return response()->json(['message' => 'Nuevo token enviado al correo electrónico'], 200);
    }

    public function login(Request $request) {
        $messages = [
            'email.required' => 'El correo es obligatorio',
            'email.email' => 'El correo no es válido',
            'password.required' => 'La contraseña es obligatoria.'
        ];
    
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Intento de Inicio de Sesión
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Correo o Contraseña incorrecta'], 422);
        }
         
        // Verificación de Email
        $user = auth('api')->user();
        if (!$user->is_verified) {
            return response()->json(['message' => 'El correo electrónico no ha sido verificado'], 401);
        }

        return response()->json([
            'user' => $user,
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
        ], 200);

    }

    public function reset_Password(Request $request){
        $request->validate(['email' => 'required|email']);

        // Verificar si el usuario exite
        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json(['message' => 'Este correo no esta registrado'], 404);
        }

        // Enviar correo con el enlace
        Mail::to($user->email)->send(new PasswordResetEmail($user));

        return response()->json(['message' => 'Correo enviado con las instrucciones para restablecer la contraseña.'], 200);
    }

    public function new_Password(Request $request, $id){
        $messages = [
            'password.redex' => 'La contraseña debe de contener al menos 8 caracteres, un símbolo y un numero',
            'password.confirmed' => 'Las contraseñas no son iguales'
        ];

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-zA-Z]/',  // Debe contener al menos una letra
                'regex:/[0-9]/',     // Debe contener al menos un número
                'regex:/[@$!%*#?&_]/' // Debe contener al menos un símbolo
            ]
        ], $messages);

       // Busca al usuario por su verification_id
       $user = User::where('verification_id', $id)->first();

       if (!$user) {
        return response()->json(['message' => 'Identificador no válido.'], 404);
        }

         // Actualiza la contraseña
         $user->password = bcrypt($request->password);
          // Opcional: Limpiar el verification_id después de restablecer la contraseña
        $user->verification_id = null;
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente.'], 200);
    }

    public function refreshToken(){
        try {

            $newToken = JWTAuth::parseToken()->refresh();
            $user = Auth::user();

            return response()->json([
                'user' => $user,
                'message' => 'token actualiado',
                'token' => $newToken,
            ], 200);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'token no inválido'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'token expirado'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar el token '], 500);
        }
    }

    public function me() {
        return response()->json(auth('api')->user());
    }

    public function logout() {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ], 200);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión, por favor intente nuevamente'
            ], 500);
        }
    }

}
