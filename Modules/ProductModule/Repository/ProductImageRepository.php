<?php

namespace Modules\ProductModule\Repository;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\ProductModule\Entities\ProductImage;

class ProductImageRepository  extends BaseRepository
{
    function model()
    {
        return ProductImage::class;
    }

    function findByType($id)
    {
        return ProductImage::where('type_id', $id)->get();
    }

    function findIDsByType($id)
    {
        return ProductImage::where('type_id', $id)->get()->pluck('id');
    }

    function getByIds($ids)
    {
        return ProductImage::whereIN('id', $ids)->get();
    }

  


}
