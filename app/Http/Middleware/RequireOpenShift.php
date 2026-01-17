<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Shift;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireOpenShift
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $openShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if (!$openShift) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => __('No open shift found. Please open a shift first.')
                ], 403);
            }
            
            session()->flash('error', __('No open shift found. Please open a shift first.'));
            return redirect()->route('admin.shifts.index');
        }

        // Make shift available to the request
        $request->merge(['current_shift' => $openShift]);
        
        return $next($request);
    }
}
