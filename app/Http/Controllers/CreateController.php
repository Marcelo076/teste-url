<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class CreateController extends Controller
{
    public function createRedirect(Request $request)
    {
        $validator = $this->validateRedirect($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Redirect::create([
            'url' => $request->input('url'),
            'date_create' => Carbon::now()->timestamp,
            'active' => true,
        ]);

        return redirect()->route('home')->with('success', 'Redirect criado com sucesso!');
    }

    protected function validateRedirect(Request $request)
    {
        return Validator::make($request->all(), [
            'url' => ['required', 'url', 'active_url', 'regex:/^https:\/\/.*[^?=]$/'],
        ]);
    }
}
