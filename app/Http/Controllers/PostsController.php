<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use App\Http\Resources\Post as PostResource;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index(Post $post) 
    {   
        return PostResource::collection(Post::all());
    } 

    public function store(Request $request, Post $post) 
    {
        $this->authorize('create', $post);

        if( request('image') !== null ) {
            $allowedExtensions = ['jpeg', 'jpg', 'png'];

                // Get file extension
            $fileExtension = explode('/', mime_content_type($request->image))[1];
            if(Str::of($fileExtension)->contains($allowedExtensions)) {

                //Make File name unique
                $imageName = time().'.'.$fileExtension;

                // Sending data to DB
                $post = auth()->user()->post()->create(array_merge($this->validateData(), ['image' => $imageName]));
                
                // Store New file to storage.
                Image::make($request->image)->save(public_path('storage/uploads/').$imageName)->resize(150, 100);

                return (new PostResource($post))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
            } 
            
        } else {
            return response()
                    ->json(['errors' => [ 'image' => ['Pole obrázok je povinný.']]], 422)
                    ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                    
        }
    } 

    public function show(Request $request, Post $post)
    {
       return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $requestPostId = $request->post_id;
        $currentImageName = Post::where('id', $requestPostId)->value('image');
        
        if( request('image') !== null ) {
            $allowedExtensions = ['jpeg', 'jpg', 'png'];

                // Get file extension
            $fileExtension = explode('/', mime_content_type($request->image))[1];
            if(Str::of($fileExtension)->contains($allowedExtensions)) {

                //Make File name unique
                $imageName = time().'.'.$fileExtension;

                // Sending data to DB
                $post->update(array_merge($this->validateData(), ['image' => $imageName]));
                // Unlink current file in storage
                if(file_exists(public_path('storage/uploads/').$currentImageName)){
                    unlink(public_path('storage/uploads/').$currentImageName);
                }
                // Store New file to storage.
                Image::make($request->image)->save(public_path('storage/uploads/').$imageName)->resize(150, 100);

                return (new PostResource($post))
                    ->response()
                    ->setStatusCode(Response::HTTP_OK);
            } 
            
        } else {
            return response()
                    ->json(['errors' => [ 'image' => ['Pole obrázok je povinný.']]], 422)
                    ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                    
        }
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if(empty($post->image)) {
            $post->delete();
        } elseif(!file_exists(storage_path('app/public/uploads/'.$post->image))) {
            $post->delete();
        } elseif(!empty($post->image) && file_exists(storage_path('app/public/uploads/'.$post->image))) {
            unlink(storage_path('app/public/uploads/'.$post->image));
            $post->delete();
        }
        return response('', Response::HTTP_NO_CONTENT);
    }

    private function validateData()
    {
        return request()->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string'    
        ]);
    }
}
