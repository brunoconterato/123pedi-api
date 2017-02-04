<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\StockItemRepository;
use Drinking\Models\StockItem;
use Drinking\Validators\StockItemValidator;

/**
 * Class StockItemRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class StockItemRepositoryEloquent extends BaseRepository implements StockItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StockItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
