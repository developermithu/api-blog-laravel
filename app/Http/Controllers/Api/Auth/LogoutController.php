<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming logout request.
     */
    public function destroy(Request $request): array
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Successfully logged out'
        ];
    }
}