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
    public function show(Media $medium)
    {
        $medium->load('users');

        return new MediaResource($medium);
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
    public function update(UpdateMediaRequest $request, Media $medium)
    {
        $medium->update($request->validated());

        return new MediaResource($medium);
    }

    // Menghapus media
    public function destroy(Media $medium)
    {
        $medium->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus'
        ]);
    }

    // Menambahkan media ke koleksi user
    public function addToCollection(User $user, Media $medium)
    {
        $user->media()->syncWithoutDetaching([$medium->id]);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi',
        ]);
    }

    // Menampilkan koleksi user
    public function userCollection(User $user)
    {
        $media = $user->media()->get();

        return MediaResource::collection($media);
    }

    // Menghapus media dari koleksi user
    public function removeFromCollection(User $user, Media $medium)
    {
        $user->media()->detach($medium->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi',
        ]);
    }
}