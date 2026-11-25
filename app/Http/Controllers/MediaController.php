<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // Menampilkan semua media dan pencarian
    public function index(Request $request)
    {
        $media = Media::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(
                    'title',
                    'like',
                    '%' . $request->search . '%'
                );
            })
            ->latest()
            ->get();

        return MediaResource::collection($media);
    }

    // Menampilkan detail satu media
    public function show(Media $media)
    {
        $media->load('users');

        return new MediaResource($media);
    }

    // Menambahkan media
    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))
            ->response()
            ->setStatusCode(201);
    }

    // Mengubah media
    public function update(UpdateMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return new MediaResource($media);
    }

    // Menghapus media
    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus'
        ]);
    }

    // Menambahkan media ke koleksi user
    public function addToCollection(User $user, Media $media)
    {
        if ($user->media()->where('media.id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna'
            ], 409);
        }

        $user->media()->attach($media->id);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi'
        ], 201);
    }

    // Menampilkan koleksi user
    public function userCollection(User $user)
    {
        $media = $user->media()->get();

        return MediaResource::collection($media);
    }

    // Menghapus media dari koleksi user
    public function removeFromCollection(User $user, Media $media)
    {
        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi'
        ]);
    }
}