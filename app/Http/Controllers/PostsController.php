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

    public function index(Post $post) 
    {
        $this->authorize('viewAny', Post::class);

        return PostResource::collection(request()->user()->posts);
    }

    public function store(Post $post, Request $request) 
    {
        $this->authorize('create', Post::class);
        
        
        if (request('image') != null) {
            $allowedExtensions = ['jpeg', 'jpg', 'png'];
        
            // Converting file from base64 binnary code, from request.
            $fileExtension = explode('/', mime_content_type($request->image))[1];

            if( Str::of($fileExtension)->contains($allowedExtensions)) {
               
                // Make File name unique.
                $imageName = time().'.'.$fileExtension;

                // Sending data to DB
                $post = request()->user()->posts()->create(array_merge($this->validateData(), ['image' => $imageName]));
                // Store file to storage.
                Image::make($request->image)->save(public_path('storage/uploads/').$imageName)->resize(200, 150);

                return (new PostResource($post))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
            }
        } else {

            return (new PostResource($post))
                ->response()
                ->setStatusCode(422);
        }
    }

    public function show(Post $post) 
    {
        $this->authorize('view', $post);

        return new PostResource($post);
    }

    public function update(Post $post) 
    {
        $this->authorize('update', $post);
        
        $post->update($this->validateData());

        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Post $post) 
    {
        $this->authorize('delete', $post);
        
        $post->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    private function validateData() 
    {
        return request()->validate([//collect
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required',
        ]);
    }
}
