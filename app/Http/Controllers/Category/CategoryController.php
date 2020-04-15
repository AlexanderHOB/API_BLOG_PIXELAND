<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    public function __construct(){
        $this->middleware('transform.input:'.CategoryTransformer::class)->only(['store','update']);
        $this->middleware('auth:api')->except('index');
        $this->middleware('client.credentials')->only('index');
    }
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        $this->allowedAdminAction();
        $rules = [
            'name'  =>  'required|min:3'
        ];
        $this->validate($request,$rules);

        $category = Category::Create($request->all());

        return $this->showOne($category);
    }

   
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category)
    {
        $this->allowedAdminAction();

        $rules=[
            'name'=>'required|min:3'
        ];
        $this->validate($request,$rules);
        
        
        $category->fill($request->only(['name','description']));

        if($category->isClean()){
            return $this->errorResponse('Debe especificar al menos un valor diferente a actualizar',422);
        }
        $category->save();
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->allowedAdminAction();

        $category->delete();
        return $this->showOne($category);
    }
}
