<?php

namespace Drinking\Http\Controllers\API\Information;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\CartItemGetterRepository;
use Illuminate\Http\Request;

class CartItemGetterController extends Controller
{
    /**
     * @var CartItemGetterRepository
     */
    private $repository;

    public function __construct(CartItemGetterRepository $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){
        $data = $request->all();

        $this->repository->create($data);

        return $data;
    }
}
