<?php

namespace Modules\LocationModule\Services;

use Modules\LocationModule\Repository\CountryRepository;

class CountryService
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAll()
    {
        return $this->countryRepository->get();
    }
    public function findOne($id)
    {
        return $this->countryRepository->findWhere(['id' => $id])->first();
    }

    public function create($data)
    {
        $country_data = [
            'name_ar' => $data->name_en,
            'name_en' => $data->name_en,
            // 'code' => $data->code,
            // 'is_active' => $data->is_active,
            // 'currency' => $data->currency,

        ];
        return $this->countryRepository->create($country_data);
    }

    public function update($data)
    {
        $country_data = [
            'name_ar' => $data->name_en,
            'name_en' => $data->name_en,
            // 'code' => $data->code,
            //'is_active' => $data->is_active,
            // 'currency' => $data->currency,

        ];

        return $this->countryRepository->update($country_data, $data->id);
    }
}
