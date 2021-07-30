<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class EnvController extends Controller
{
    /**
     * Upload a .env-file and replace the current one
     *
     * @return Redirector|RedirectResponse|Application
     */
    public function upload()
    {
        $file = request()->file('backup');
        $file->move(base_path(), '.env');
        return redirect(config('dotenveditor.route.prefix'));
    }
}
