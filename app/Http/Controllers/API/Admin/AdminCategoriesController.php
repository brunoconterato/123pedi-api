<?php

namespace Drinking\Http\Controllers\API\Admin;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class AdminCategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    //TODO: inicializar CategoryRepository, arrumando o bind do RepositoryServiceProvider
    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    
    public function index(){
        $categories = $this->categoryRepository->all();

        return $categories;
    }
    
    //TODO: fazer request especifico
    public function store(Request $request){
        $data = $request->all();

        $category = $this->categoryRepository->create($data);

        return $category;
    }
    
    public function update(Request $request, $id){
        $data = $request->all();
        
        $category = $this->categoryRepository->update($data, $id);
        
        return $category;
    }

    public function show($id){
        $category = $this->categoryRepository->find($id);

        return $category;
    }
}
