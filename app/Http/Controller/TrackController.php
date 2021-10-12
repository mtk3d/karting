<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Illuminate\View\View;
use Karting\Track\Track;

class TrackController
{
    public function index(): View
    {
        return view('track.index', ['tracks' => Track::all()]);
    }
}
