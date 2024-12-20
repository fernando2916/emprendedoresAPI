<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(Post::all(), 200);

        // $post = Post::with('categoria')->get();

        // return PostsResource::collection($post);
        return new PostsCollection(Post::where('estado', 'publicado')->orderby('id')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
        'titulo' => 'required|string|max:255',
        'imagen_url' => 'nullable|string',
        'descripción_corta' => 'nullable|string|max:500',
        'contenido' => 'required|string',
        'categoria_posts_id' => 'required|exists:categoria_posts,id',
        'slug' => 'required|string|unique:posts,slug|max:255',
        'tipo' => 'required|in:articulo,noticia,blog',
        'tiempo_de_lectura' => 'nullable|string|max:50',
        'user_id' => 'required|exists:users,id',
        'estado' => 'required|in:pendiente,publicado,borrador',
        ]);

        $post = Post::create($validateData);

        return response()->json([
            'message' => 'Publicación creada exitosamente.',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        //
        // $blogs = Blog::whith('slug', $slug)
        // 
                    //    ->firstOrFail();
        
        $blog = Post::with('categoria')->where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'Blog no encontrado'], 404);
        }

        return new PostsResource($blog);
    }

    // public function show(string $id)
    // {
    //     $post = Post::find($id);

    //     if (!$post) {
    //         return response()->json(['message' => 'Publícación no encontrada'], 404);
    //     }

    //     return response()->json($post, 200);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Publicación no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'imagen' => 'sometimes|string|max:255',
            'contenido' => 'sometimes|string',
            'autor' => 'nullable|string|max:255',
            'estado' => 'sometimes|in:draft,published',
        ]);

        $post->update($validatedData);

        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Publicación no encontrada'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Pubñicación eliminada correctamente'], 200);
    }
}
