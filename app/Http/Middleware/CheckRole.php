<?php

namespace App\Http\Middleware;

use App\Constants\Constants;
use Closure;
use Illuminate\Http\Request;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // protected $roleUser;
    // public function __construct(RoleUser $roleUser)
    // {
    //     $this->roleUser = $roleUser;
    // }

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->id == 27) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}
