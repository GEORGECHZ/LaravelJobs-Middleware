<?php

namespace App\Http\Middleware;

use App\Jobs\SendEmailJob;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\IntentosUser; // Asegúrate de tener este modelo
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactanosMail; // Asegúrate de tener este Mailable

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) // Si el usuario no está logueado
        {
            return redirect('/login'); // Redirige a la página de login
        }

        $user = Auth::user(); // Obtiene el usuario logueado

        // Registra el intento del usuario
        $intentar = new IntentosUser;
        $intentar->user_id = $user->id;
        $intentar->route = $request->path();

        if (in_array($user->role, $roles)) // Si el usuario tiene uno de los roles permitidos
        {
            $intentar->access_granted = 1;
            $intentar->save();

            return $next($request); // Continúa con la solicitud
        } else {
            $intentar->access_granted = 0;
            $intentar->save();

            // Verifica si el usuario ha tenido 5 intentos fallidos
            $failed_attempts = IntentosUser::where('user_id', $user->id)
                ->where('access_granted', 0)
                ->count();

            if ($failed_attempts % 5 == 0) {
                // Envía un correo al usuario
                SendEmailJob::dispatchAfterResponse($user);
                SendEmailJob::dispatch($user);
            }

            return redirect('/unauthorized'); // Redirige a una página de error
        }
    }
}
