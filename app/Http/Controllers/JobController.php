<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{

    public function add( Request $request ) {
        $entitty = Entity::whereName( $request->input("company") )->firstOrFail();

        if ($entitty==null)
        {

        }
        else
        {

        }


        return back();
    }

}