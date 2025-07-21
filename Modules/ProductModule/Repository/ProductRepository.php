<?php

namespace Modules\ProductModule\Repository;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\ProductModule\Entities\Product;

class ProductRepository  extends BaseRepository
{
    function model()
    {
        return Product::class;
    }

    function findByType($id)
    {
        return Product::where('type_id', $id)->get();
    }

    function findIDsByType($id)
    {
        return Product::where('type_id', $id)->get()->pluck('id');
    }

    function getByIds($ids)
    {
        return Product::whereIN('id', $ids)->get();
    }

    function getRandom($rand)
    {
        return Product::get()->random($rand);
    }

    function findAllWithActions($arr_actions = [], $items = 16)
    {
        
        $query = Product::select('products.*');


        if (!empty($arr_actions)) {
            //Search By///

            if (key_exists('search_by', $arr_actions)) {
                foreach ($arr_actions['search_by'] as $col => $search_by) {
                    $query->whereRaw('UPPER(' . $col . ') LIKE "%' . strtoupper($search_by) . '%"');
                }
            }

            ////////////
            //Order By///
            if (key_exists('order_by', $arr_actions)) {
                foreach ($arr_actions['order_by'] as $col => $order_by) {
                    $query->orderBy($col, $order_by);
                }
            }
            ////////////
            if (key_exists('filter', $arr_actions)) {
                foreach ($arr_actions['filter'] as $col => $filter) {
                    $query->Where($col, $filter);
                }
            }
        }

        return $query->paginate($items);
    }

    function getProductPrice($id)
    {
        return Product::where('id', $id)->first()->price;
    }



}
