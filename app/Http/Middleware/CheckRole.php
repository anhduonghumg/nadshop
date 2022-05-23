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
        $id = Auth::id();
        if ($this->roleUser->get_role($id) === Constants::ADMIN) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
