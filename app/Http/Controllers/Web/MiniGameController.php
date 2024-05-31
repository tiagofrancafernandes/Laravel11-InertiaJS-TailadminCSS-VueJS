<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiniGameController extends Controller
{
    public function play(Request $request, string $game): \Illuminate\Contracts\View\View
    {
        $viewPath = implode('.', [
            'mini-game',
            $game,
            // square-man,
            'play',
        ]);

        return view($viewPath, [
            'request' => $request,
        ]);
    }
}
