<?php

namespace Drinking\Http\Controllers\Admin;


use Drinking\Http\Controllers\Controller;
use Drinking\Http\Requests\Admin\AdminProductRequest;
use Drinking\Repositories\CategoryRepository;
use Drinking\Repositories\ClientRepository;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{

    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    private $userRepository;
    private $clientRepository;

    public function __construct(ProductRepository $productRepository,
                                CategoryRepository $categoryRepository,
                                UserRepository $userRepository,
                                ClientRepository $clientRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
    }

    public function index()
    {
//        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
//        $products = $this->productRepository->scopeQuery(function($query) use($clientId){
//            return $query->where('client_id','=',$clientId);
//        })->paginate();

        $products = $this->productRepository->paginate();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->pluck(['name','id']);
        return view('admin.products.create', compact('categories') );
    }

    public function store(AdminProductRequest $request)
    {
        $data = $request->all();
        //$this->productRepository->create($data);

        $this->productRepository->create($data);

        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        $categories = $this->categoryRepository->pluck(['name','id']);

        //Code to find images (if exists) and send the image to the view
        $specificPath = '/images/products/';
        $imagesFolderPath = base_path() . '/public' . $specificPath;
        $exts = array('bmp','png','jpg','jpeg');
        $hasImages = false;
        foreach($exts as $ext) {
            if(file_exists($imagesFolderPath . $product->id . "." . $ext)) {
                $imagesPath = $specificPath . $product->id . "." . $ext;
                $imagesPath = str_replace('\\','/',$imagesPath);
                $hasImages = true;
                break;
            }
        }

        return view('admin.products.edit', compact('product','categories','hasImages','imagesPath'));
    }

    public function update(AdminProductRequest $request, $id)
    {
        $data = $request->all();
        $this->productRepository->update($data, $id);

        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('admin.products.index');
    }

    public function deleteImage($id)
    {
        $product = $this->productRepository->find($id);

        //Code to find images (if exists) and send the image to the view
        $specificPath = '/images/products/';
        $imagesFolderPath = base_path() . '/public' . $specificPath;
        $exts = array('bmp','png','jpg','jpeg');
        $hasImages = false;
        foreach($exts as $ext) {
            if(file_exists($imagesFolderPath . $product->id . "." . $ext)) {
                $imagesPath = $specificPath . $product->id . "." . $ext;
                $imagesPath = str_replace('\\','/',$imagesPath);
                $hasImages = true;
                break;
            }
        }

        if($hasImages) {
            //dd(str_replace('\\','/',$imagesFolderPath . $product->id . "." . $ext));
            File::delete(str_replace('\\','/',$imagesFolderPath . $product->id . "." . $ext));
        }

        return redirect()->route('admin.products.edit', ['id'=>$id]);
    }
}