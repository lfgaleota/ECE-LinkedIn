<?php

namespace App\Http\Controllers;

use App\Entity;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EntityController extends Controller {
	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), Entity::validation_create );

		if( $validator->fails() ) {
			return redirect()->back()->withErrors( $validator )->withInput();
		}

		$params = $request->all();
		$params[ 'photo_url' ] = \App\Utils::getFileUrl( Utils::store( Auth::user(), $request->file( 'photo' ), 'images' ) );
		$params[ 'author_id' ] = Auth::user()->user_id;

		Entity::create( $params );

		return redirect()->route( 'entity.list.own' );
	}

	public function update( Request $request, $id ) {
		$validator = Validator::make( $request->all(), Entity::validation_update );

		if( $validator->fails() ) {
			return redirect()->back()->withErrors( $validator )->withInput();
		}

		$entity = Entity::findOrFail( $id );

		if( !Auth::user()->hasFullEditRight() && !$entity->author->isSame( Auth::user() ) ) {
			return response( 'Unauthorized.', 401 );
		}

		if( $request->has( 'name' ) ) {
			$entity->name = $request->get( 'name' );
		}
		if( $request->has( 'description' ) ) {
			$entity->description = $request->get( 'description' );
		}
		if( $request->has( 'location' ) ) {
			$entity->location = $request->get( 'location' );
		}
		if( $request->hasFile( 'photo' ) ) {
			$entity->setPhoto( $request->file( 'photo' ) );
		}

		$entity->save();

		return redirect()->route( 'entity.list.own' );
	}

	public function create() {
		return view( 'app.entity.create' );
	}

	public function edit( $id ) {
		$entity = Entity::findOrFail( $id );

		if( !Auth::user()->hasFullEditRight() && !$entity->author->isSame( Auth::user() ) ) {
			return response( 'Unauthorized.', 401 );
		}

		return view( 'app.entity.edit', [ 'entity' => $entity ] );
	}

	public function list() {
		$entities = Entity::paginate( 20 );

		return view( 'app.entity.list', [ 'entities' => $entities, 'editable' => Auth::user()->hasFullEditRight() ] );
	}

	public function listOwn() {
		if( Auth::user()->hasFullEditRight() ) {
			$entities = Entity::paginate( 20 );
		} else {
			$entities = Entity::whereAuthorId( Auth::user()->user_id )->paginate( 20 );
		}

		return view( 'app.entity.list', [ 'entities' => $entities, 'editable' => true ] );
	}

	public function show( $id ) {
		$entity = Entity::findOrFail( $id );
		return view( 'app.entity.show', [ 'entity' => $entity ] );
	}

	public function getAll() {
		return response()->json( Entity::all() );
	}

	public function deleteAsk( $id ) {
		$entity = Entity::findOrFail( $id );
		return view( 'app.entity.delete', [ 'entity' => $entity ] );
	}

	public function delete( $id ) {
		Entity::findOrFail( $id )->delete();
		return redirect()->route( 'entity.list' );
	}
}

