<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;


class CategoriesController extends Controller
{

  //retorna todas as categorias
  public function index(Category $category)
  {
    return Category::all();
  }

  //Cria uma categoria
  public function store(Request $request)
  {
    $category = Category::create($request->all());
    return response()->json($category, 201);
  }

  //Apaga categoria
  public function destroy(int $category)
  {
    Category::destroy($category);
    return response()->noContent();
  }

  //Atualiza categorias 
  public function update(Request $request)
  {

    if (Category::find($request->id) === null) {
      return response()->json(['message' => 'category not found'], 404);
    }

    $category = Category::find($request->id);
    $category->fill($request->all());
    $category->save();

  }
}
