<?php

namespace Modules\LocationModule\Services;

use Modules\LocationModule\Repository\CityRepository;

class CityService
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAll()
    {
        return $this->cityRepository->get();
    }

    public function getByCountryWith($country_id, $array_with)
    {
        return $this->cityRepository->findwith(['country_id' => $country_id], $array_with);
    }

    public function getByCountry($country_id)
    {
                // return $this->cityRepository->findwhereBySort($country_id);

        return $this->cityRepository->findwhere(['country_id' => $country_id]);
    }

    public function findOne($id)
    {
        return $this->cityRepository->find($id);
    }

    public function create($data)
    {
        
        $city_data = [
            'name_ar' => $data->name_en,
            'name_en' => $data->name_en,
            // 'latitude' => $data->latitude,
            //'is_active' => $data->is_active,
            // 'longitude' => $data->longitude,
            'country_id' => $data->country_id,

        ];
        return $this->cityRepository->create($city_data);
    }
    public function update($data)
    {
        $city_data = [
            'name_ar' => $data->name_en,
            'name_en' => $data->name_en,
            // 'latitude' => $data->latitude,
            //'is_active' => $data->is_active,
            // 'longitude' => $data->longitude,
            'country_id' => $data->country_id,

        ];

        return $this->cityRepository->update($city_data, $data->id);
    }

}
