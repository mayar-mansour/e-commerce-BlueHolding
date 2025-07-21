<?php

namespace Modules\ProductModule\Repository;

use Modules\ProductModule\Entities\Category;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\ProductModule\Entities\Product;

class CategoryRepository  extends BaseRepository
{
    function model()
    {
        return Category::class;
    }

    function findByType($id)
    {
        return Category::where('type_id', $id)->get();
    }

    function findIDsByType($id)
    {
        return Category::where('type_id', $id)->get()->pluck('id');
    }

    function getByIds($ids)
    {
        return Category::whereIN('id', $ids)->get();
    }

    function getRandom($rand)
    {
        return Category::get()->random($rand);
    }

  

  



}
