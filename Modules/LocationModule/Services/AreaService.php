<?php

namespace Modules\LocationModule\Services;

use Modules\LocationModule\Repository\AreaRepository;

class AreaService
{
    private $areaRepository;

    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function getAll()
    {
        return $this->areaRepository->get();
    }

    public function getByCity($city_id)
    {
        return $this->areaRepository->findWhere(['city_id' => $city_id]);
    }
    public function getByCityWith($city_id, $array_with)
    {
        return $this->areaRepository->findwith(['city_id' => $city_id], $array_with);
    }
    public function create($data)
    {
        $area_data = [
            'name_ar' => $data->name_ar,
            'name_en' => $data->name_ar,
            'latitude' => $data->latitude,
            //'is_active' => $data->is_active,
            'longitude' => $data->longitude,
            'city_id' => $data->city_id,

        ];
        return $this->areaRepository->create($area_data);
    }

    public function update($data)
    {

        $area_data = [
            'name_ar' => $data->name_ar,
            'name_en' => $data->name_ar,
            'latitude' => $data->latitude,
            //'is_active' => $data->is_active,
            'longitude' => $data->longitude,
            'city_id' => $data->city_id,

        ];

        return $this->areaRepository->update($area_data, $data->id);
    }
}
