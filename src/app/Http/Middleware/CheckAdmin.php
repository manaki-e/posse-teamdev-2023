<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //get previous url without APP_URL
        $previous_url = str_replace(config('app.url'), '', url()->previous());
        //一般ユーザーがユーザー画面から管理者画面に遷移しようとしている場合
        if (strpos($previous_url, 'admin') !== 0 && auth()->user()->is_admin === 0) {
            return redirect()->back()->with(['flush.message' => '管理者のみアクセスできます。', 'flush.alert_type' => 'warning']);
        }
        return $next($request);
    }
}
