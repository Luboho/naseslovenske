<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use App\Http\Resources\Profile as ProfileResource;
use Symfony\Component\HttpFoundation\Response;

class ProfilesController extends Controller
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

    public function index(Profile $profile) 
    {
        return ProfileResource::collection(Profile::all());
    }

    public function store(Profile $profile, Request $request) 
    {
        $this->authorize('create', Profile::class);

        if( request('image') !== null ) {
            $allowedExtensions = ['jpeg', 'jpg', 'png'];

                // Get file extension
            $fileExtension = explode('/', mime_content_type($request->image))[1];
            if(Str::of($fileExtension)->contains($allowedExtensions)) {

                //Make File name unique
                $imageName = time().'.'.$fileExtension;

                // Sending data to DB
                $profile = auth()->user()->profile()->create(array_merge($this->validateData(), ['image' => $imageName]));
                
                // Store New file to storage.
                Image::make($request->image)->save(public_path('storage/uploads/').$imageName)->resize(150, 100);

                return (new ProfileResource($profile))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
            } 
            
        } else {
            return response()
                    ->json(['errors' => [ 'image' => ['Pole obrázok je povinný.']]], 422)
                    ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show(Profile $profile) 
    {
        return new ProfileResource($profile);
    }


    public function update(Request $request, Profile $profile) 
    {
        $this->authorize('update', $profile);

        $requestProfileId = $request->profile_id;
        $currentImageName = Profile::where('id', $requestProfileId)->value('image');
        
        if( request('image') !== null ) {
            $allowedExtensions = ['jpeg', 'jpg', 'png'];

                // Get file extension
            $fileExtension = explode('/', mime_content_type($request->image))[1];
            if(Str::of($fileExtension)->contains($allowedExtensions)) {

                //Make File name unique
                $imageName = time().'.'.$fileExtension;

                // Sending data to DB
                $profile->update(array_merge($this->validateData(), ['image' => $imageName]));
                // Unlink current file in storage
                if(file_exists(public_path('storage/uploads/').$currentImageName)){
                    unlink(public_path('storage/uploads/').$currentImageName);
                }
                // Store New file to storage.
                Image::make($request->image)->save(public_path('storage/uploads/').$imageName)->resize(150, 100);

                return (new ProfileResource($profile))
                    ->response()
                    ->setStatusCode(Response::HTTP_OK);
            } 
            
        } else {
            return response()
                    ->json(['errors' => [ 'image' => ['Pole obrázok je povinný.']]], 422)
                    ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                    
        }  
    }

    public function destroy(Profile $profile) 
    {
        $this->authorize('delete', $profile);
        
        if(empty($profile->image)) {
            $profile->delete();
        } elseif(!file_exists(storage_path('app/public/uploads/'.$profile->image))) {
            $profile->delete();
        } elseif(!empty($profile->image) && file_exists(storage_path('app/public/uploads/'.$profile->image))) {
            unlink(storage_path('app/public/uploads/'.$profile->image));
            $profile->delete();
        }
        return response('', Response::HTTP_NO_CONTENT);
    }

    private function validateData() 
    {
        return request()->validate([//collect
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
    }

    private function validateFile($input)
    {   
        if(request('image') !== null) {
            $allowedExtensions = ['jpeg', 'jpg', 'png'];

            $str = base64_decode($input, true);

            // Invalid Base64
            if ($str === false) {
                return (new ProfileResource($profile))
                    ->response()
                    ->setStatusCode(Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
            } else {
                // Check decoded string against 
                $b64 = base64_encode($str);

                // Check if input string & real Base64 are identical
                if ($input === $b64) {
                    // Valid Base64
                } else {
                    // Invalid Base64
                }
            }




            $fileExtension = explode('/', mime_content_type($request->image))[1];
        }
    }
}
