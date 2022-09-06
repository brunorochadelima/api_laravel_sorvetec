<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostsFormRequest;


class PostsController extends Controller
{

    //Retorna todos os posts ou busca ao usar atributo title
    //Ex: http://127.0.0.1:8000/api/posts?title=8%20RECEITAS
    public function index(Request $request)
    {
        $query = Post::query();
        if ($request->has('title')) {
            $query->where('post_title', 'LIKE', "%$request->title%");
        }
        return $query->paginate(8);
    }

    // retorna 1 post
    public function show(int $post)
    {
        $postModel = Post::find($post);
        if ($postModel === null) {
            return response()->json(['message' => 'post not found'], 404);
        }
        return $postModel;
    }

    //Retorna posts por categoria
    public function show_post_by_category(Request $request)
    {
        $params = ($request->id);
        $posts = Post::where('category_id', $params)->paginate(2);
        return $posts;
    }

    //Cria um post
    public function store(PostsFormRequest $request)
    {
        // nome do arquivo
        $fileName = $request->file('post_cover')->getClientOriginalName();
        $fileNameSemEspaco = str_replace(' ', '_', $fileName);
        $extension = $request->file('post_cover')->getClientOriginalExtension();

        // $post = Post::create($request->all());
        $post = Post::create([
            'post_title' => $request->post_title,
            'post_text' => $request->post_text,
            'category_id' => $request->category_id,
            'post_cover' => $request->file('post_cover')->storeAs('posts_cover', $fileNameSemEspaco . '_' . time() . '.' . $extension, 'public'),
        ]);

        return response()->json($post, 201);
    }

    //Apaga post
    public function destroy(int $post, Request $request)
    {
        //encontra o post
        $postModel = Post::find($post);

        //encontra o caminho da imagem
        $imgPath = $postModel['post_cover'];

        //apaga a imagem
        Storage::disk('public')->delete($imgPath);

        //apaga as demais informações do post
        Post::destroy($post);
        return response()->noContent();
    }

    //Atualiza post
    public function update(Request $request)
    {
        if ($post = Post::find($request->id) === null) {
            return response()->json(['message' => 'post not found'], 404);
        }

        $post = Post::find($request->id);
        // $post = Post::findOrFail($request->id); também é possível fazer desta maneira!
        $post->fill($request->all());
        $post->save();
        return response()->json($post);
    }

}