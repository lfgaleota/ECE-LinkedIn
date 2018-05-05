<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{

    public function add( Request $request ) {
        $entitty = Entity::whereName( $request->input("company") )->firstOrFail();
$job= new JobOffer;

        if ($entitty==null)
        {
            $entitty= new Entity;
            $entitty->setName($request->input("company"));
            $entitty->setAuthor(Auth::user()->user_id);

        }
$job->setEntity($entity->entity_id);
$job->setPosition($request->input("position"));

$job->setPosition($request->input("description"));
        return back();
    }


public function show(){
        return view( 'app.job.job');
}
}    

