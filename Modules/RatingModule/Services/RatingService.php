<?php

namespace Modules\RatingModule\Services;

use App\Helpers\UploaderHelper;
use Modules\RatingModule\Repository\RatingRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Modules\CategoryModule\Repository\CategoryRepository;

class RatingService {

    use UploaderHelper;

    public $ratingRepository;



    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;

    }

     /**
     * ------------------------------
     * Filter
     * ------------------------------
     *
     * Filter category according to sended array
     *
     * @key parent_id
     * @key name
     *
     * @param array $request
     *
     * @return query
     */

    public function filter(array $request)
    {
        return $this->ratingRepository->filter($request);
    }

    /**
     * ------------------------------
     * Latest Records
     * ------------------------------
     *
     * Get Latest Categories add to the system
     *
     * @param int $limit
     *
     * @return object
     */

    public function latest($limit = 5)
    {
        return $this->ratingRepository->lastest($limit);
    }




    /**
     * ------------------------------
     * find category
     * ------------------------------
     *
     * Get category
     *
     *  param $id
     *
     * @return object
     */

    public function findOne($id)
    {
        return $this->ratingRepository->find($id);
    }

    /**
     * ------------------------------
     * get Categories Shop
     * ------------------------------
     *
     * Get Categories For Shop
     *
     *
     * @return object
     */

    public function create($data)
    {
    
           $rate =  $this->ratingRepository->create([
            
                'star' =>$data['star'],
                'comment' =>$data['comment'],
                'customer_id' =>Auth::guard('user')->user()->id,
            ]);
         

            return $rate;
        
    }


    /** 
     * Return All Categories
     * @return object
    */

    public function findAll()
    {
        return $this->ratingRepository->get();
    }





    /**
     *  Find cusomter 
     *  @param $customerArray (Customer information)
     *  @return Customer  
     */

     public function findWhere(array $customerArray)
     {
         return $this->ratingRepository->where($customerArray)->first();
     }
   
     
     // RatingService.php
     
     public function createOrUpdateRating($data)
     {
         // Check if the user has already rated this product
         $existingRating = $this->ratingRepository->findWhere([
             'product_id' => $data['product_id'],
             'user_id' => $data['user_id']
         ])->first();
         if ($existingRating) {
             // Update the existing rating
             return $this->ratingRepository->update($data, $existingRating->id);
         } else {
             // Create a new rating
             return $this->ratingRepository->create($data);
         }
     }
     
     public function calculateAverageRating($product_id)
     {
         return $this->ratingRepository->where('product_id', $product_id)->avg('star');
     }

}
