<?php

namespace Drinking\Http\Controllers\API\Information;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\SearchRepository;
use Illuminate\Http\Request;

class SearchGetterController extends Controller
{
    /**
     * @var SearchRepository
     */
    private $repository;

    public function __construct(SearchRepository $repository){
        $this->repository = $repository;
    }
    
    public function store(Request $request){
        $data = $request->all();

        $this->repository->create($data);
        
        return $data['search_term'];
    }
}
