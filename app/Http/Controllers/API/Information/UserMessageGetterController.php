<?php

namespace Drinking\Http\Controllers\API\Information;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\UserMessageGetterRepository;
use Illuminate\Http\Request;

class UserMessageGetterController extends Controller
{
    /**
     * @var UserMessageGetterRepository
     */
    private $repository;

    public function __construct(UserMessageGetterRepository $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){
        $data = $request->all();

        $this->repository->create($data);

        return $data;
    }
}
