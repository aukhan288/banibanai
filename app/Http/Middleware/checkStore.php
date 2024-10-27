<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class CheckStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has a role and if it's one of the allowed roles
        if (in_array($user->role->slug, ['catering', 'chairity', 'venu'])) {
             // Count the number of stores associated with the user
        $storeCount = Store::where('user_id', $user->id)->count();

        // Check if store count is less than 1
        if ($storeCount < 1) {
            return response()->view('no_stores');
        }
         // Attach the store count to the request for later use if needed
         $request->attributes->set('storeCount', $storeCount);
        }

       

       

        // Proceed to the next middleware/request handler
        return $next($request);
    }
}
