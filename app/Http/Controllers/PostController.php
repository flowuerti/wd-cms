<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use DB;

//use User;

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$users = User::all();

		$authUser = User::find( Auth::user()->id );

		$posts = Post::orderBy( 'id', 'desc' )->paginate( 20 );

		$authUserPost = Post::where( 'author_id', $authUser->id );

		$postsPublished = $this->showAllPublishedPosts();
		$postsTrash   = $this->postsInTrash();
		$postsDrafts  = $this->postsInDrafts();

		return view( 'manage.posts.index', compact( 'posts', 'users', 'authUserPost', 'postsPublished', 'postsTrash', 'postsDrafts' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'manage.posts.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {

		$validatedData = $request->validate( [
			'post_title'     => 'required|min:5|max:255',
			'post_content'   => 'required|min:5',
			'post_thumbnail' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
		] );

		$post               = new Post();
		$post->post_title   = $request->post_title;
		$post->post_content = $request->post_content;
		$post->post_type    = 'posts';
		$post->author_id    = Auth::user()->id;
		$post->published_at = Carbon::now();

		if ( $request->hasFile( 'post_thumbnail' ) ) {

			// Get image file
			$image = $request->file( 'post_thumbnail' );

			$filename = $image->getClientOriginalName();

			$location = public_path( '/uploads/images/' . $filename );

			Image::make( $image->getRealPath() )->save( $location );

			$post->image = $filename;
		};

		$post->save();

		return redirect()->route( 'posts.show', $post->id );


	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {

		$post = Post::findOrFail( 'id', $id );

		return view( 'manage.posts.show', compact( 'post' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {

		$post = Post::findOrFail( $id );

		return view( 'manage.posts.edit', compact( 'post' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {

		$validatedData = $request->validate( [
			'post_title'   => 'required|max:255',
			'post_content' => 'required|min:5',
			'image'        => 'image|mimes:jpeg,png,jpg,svg|max:2048'

		] );

		$post               = Post::findOrFail( $id );
		$post->post_title   = $request->post_title;
		$post->post_content = $request->post_content;

		if ( $request->hasFile( 'image' ) ) {

			// Get image file
			$image = $request->file( 'image' );

			$filename = $image->getClientOriginalName();

			$location = public_path( '/uploads/images/' . $filename );

			Image::make( $image->getRealPath() )->save( $location );

			$post->post_thumbnail = $filename;
		};

		$post->save();


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {

		//

	}

	public function drafts() {

		$users = User::all();

		$authUser = User::find( Auth::user()->id );

		$posts = Post::where( 'deleted_at' );

		$postsDrafts = Post::where( 'post_status', '1' )->orderBy( 'id', 'desc' )->paginate( 20 );

		$authUserPost = Post::where( 'author_id', $authUser->id );

		$postsPublished = $this->showAllPublishedPosts();

		$postsTrash = $this->postsInTrash();


		return view( 'manage.posts.drafts', compact( 'postsDrafts', 'posts', 'authUserPost', 'postsPublished', 'users', 'postsTrash' ) );
	}


	public function trash() {

		$postsTrash = Post::onlyTrashed()->orderBy( 'id', 'desc' )->paginate( 20 );
		$posts      = Post::whereNull( 'deleted_at' );

		$authUser     = User::find( Auth::user()->id );
		$authUserPost = Post::where( 'author_id', $authUser->id );

		$postsPublished = $this->showAllPublishedPosts();
		$postsDrafts  = $this->postsInDrafts();


		return view( 'manage.posts.trash', compact( 'postsTrash', 'posts', 'authUserPost', 'postsPublished', 'postsDrafts' ) );

	}

	public function published() {

		$users = User::all();

		$authUser = User::find( Auth::user()->id );

		$posts = Post::where( 'deleted_at' );

		$postsDrafts = Post::where( 'post_status', '1' )->orderBy( 'id', 'desc' )->paginate( 20 );

		$authUserPost = Post::where( 'author_id', $authUser->id );

		$postsPublished = $this->showAllPublishedPosts();

		$postsTrash = $this->postsInTrash();

		return view( 'manage.posts.published', compact( 'postsTrash', 'posts', 'authUserPost', 'postsPublished', 'postsDrafts', 'users', 'postsTrash' ) );

	}

	public function toTrash( $id ) {

		$post = Post::where('id',$id)->first();

		$post->delete();

		$post->save;

		return redirect()->route( 'posts.index' );

	}

	public function showAllPublishedPosts() {

		$posts = Post::where( 'post_status', 3 )->get();

		$posts->published = $posts;

		return $posts->published;
	}

	public function postsInTrash() {

		$posts = Post::onlyTrashed()->get();

		$posts->trash = $posts;

		return $posts->trash;
	}

	public function postsInDrafts() {

		$posts = Post::where( 'post_status', '1' )->get();

		$posts->drafts = $posts;

		return $posts->drafts;

	}


}
