<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Redirect;

class inactiveController extends Controller
{
    
    public function desactivateRedirect($id)
    {
        $redirect = Redirect::findOrFail($id);


        if ($redirect->active == 1) {
            $redirect->update(['active' => 0]);
            $message = 'Redirect desativado com sucesso!';
        } else {
            // Caso esteja desativado, ativá-lo
            $redirect->update(['active' => 1]);
            $message = 'Redirect ativado com sucesso!';
        }

        return redirect()->route('redirects.index')->with('success', $message);
    }
}
