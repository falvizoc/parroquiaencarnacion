<?php

namespace App\Http\Controllers;

use App\Models\FaithfulMember;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificacionController extends Controller
{
    /**
     * Verificar email de un fiel.
     */
    public function verificarEmail(Request $request, string $locale, int $id, string $token): View
    {
        $fiel = FaithfulMember::find($id);

        // Verificar si el fiel existe
        if (!$fiel) {
            return view('pages.verificacion-resultado', [
                'exito' => false,
                'mensaje' => __('El enlace de verificación no es válido.'),
                'tipo' => 'error',
            ]);
        }

        // Verificar si ya está verificado
        if ($fiel->email_verificado_at) {
            return view('pages.verificacion-resultado', [
                'exito' => true,
                'mensaje' => __('Tu correo electrónico ya fue verificado anteriormente.'),
                'tipo' => 'info',
                'fiel' => $fiel,
            ]);
        }

        // Verificar token
        if ($fiel->verificarEmail($token)) {
            return view('pages.verificacion-resultado', [
                'exito' => true,
                'mensaje' => __('¡Tu correo electrónico ha sido verificado exitosamente!'),
                'tipo' => 'success',
                'fiel' => $fiel,
            ]);
        }

        // Token inválido
        return view('pages.verificacion-resultado', [
            'exito' => false,
            'mensaje' => __('El enlace de verificación ha expirado o no es válido.'),
            'tipo' => 'error',
        ]);
    }

    /**
     * Reenviar email de verificación.
     */
    public function reenviarVerificacion(Request $request, string $locale): View
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $fiel = FaithfulMember::where('email', $request->email)->first();

        if (!$fiel) {
            return view('pages.verificacion-resultado', [
                'exito' => false,
                'mensaje' => __('No encontramos un registro con ese correo electrónico.'),
                'tipo' => 'warning',
            ]);
        }

        if ($fiel->email_verificado_at) {
            return view('pages.verificacion-resultado', [
                'exito' => true,
                'mensaje' => __('Tu correo electrónico ya está verificado.'),
                'tipo' => 'info',
                'fiel' => $fiel,
            ]);
        }

        // Generar nuevo token y enviar email
        $fiel->generarTokenVerificacion();

        // Enviar email
        \Illuminate\Support\Facades\Mail::to($fiel->email)
            ->send(new \App\Mail\VerificacionFielMail($fiel));

        return view('pages.verificacion-resultado', [
            'exito' => true,
            'mensaje' => __('Hemos enviado un nuevo correo de verificación a :email.', ['email' => $fiel->email]),
            'tipo' => 'success',
        ]);
    }
}
