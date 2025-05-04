<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    

     public function handle(Request $request, Closure $next, ...$roles): Response
     {
         // Vérifie si l'utilisateur est authentifié
         if (!Auth::check()) {
             return redirect()->route('login');
         }
 
         // Récupère l'utilisateur connecté
         $user = Auth::user();
 
         // Vérifie si le rôle de l'utilisateur est dans la liste autorisée
         if (!in_array($user->role, $roles)) {
             abort(403, 'Unauthorized – Rôle non autorisé');
         }
 
         return $next($request);
     }
     
}
