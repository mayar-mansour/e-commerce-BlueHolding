<?php

namespace App\Helpers;

use Modules\DoctorModule\Entities\DoctorTime;
use Response;
use Validator;

trait ApiResponseHelper
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var array
     */
    protected $body;
    /**
     * Set response data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->body['data'] = $data;
        return $this;
    }
    public function setStatus($status)
    {
        $this->body['status'] = $status;
        return $this;
    }
    public function setCode($code)
    {
        $this->body['code'] = $code;
        return $this;
    }
    public function setMessage($message)
    {
        $this->body['message'] = $message;
        return $this;
    }
    public function setError($error)
    {
        $this->body['errors'] = $error;
        return $this;
    }
    public function setCurrentPage($page = 1)
    {
        $this->body['current_page'] = $page;
        return $this;
    }
    public function setPagesNumber($pages = 1)
    {
        $this->body['total_pages'] = $pages;
        return $this;
    }
    public function json($code, $status, $data, $message, $page = null, $pages = null)
    {
        $this->setCode($code);
        $this->setStatus($status);
        $this->setData($data);
        $this->setMessage($message);
        if ($page) {
            $this->setCurrentPage($page);
        }
        if ($pages) {
            $this->setPagesNumber($pages);
        }
        return response()->json($this->body, $code);
    }
    public function error($code, $status, $errors, $message = '')
    {
        $this->setCode($code);
        $this->setStatus($status);
        $this->setError($errors);
        $this->setMessage($message);
        return response()->json($this->body, $code);
    }
    public function reFormatValidationErr($validation_obj)
    {
        $response = [];
        $arr_errors = $validation_obj->toArray();
        if (count($arr_errors) > 0) {
            foreach ($arr_errors as $errs) {
                foreach ($errs as $one_err_msg) {
                    $response[] = $one_err_msg;
                }
            }
        }
        return $response[0];
    }
    // // Helper function to check if the provided time slot overlaps with existing ones
    private function isTimeSlotOverlap($doctorId, $dayNumber, $startTime, $endTime)
    {
        $existingSlots = DoctorTime::where('doctor_id', $doctorId)
            ->where('day_nu', $dayNumber)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_at', [$startTime, $endTime])
                    ->orWhereBetween('end_at', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_at', '<=', $startTime)
                            ->where('end_at', '>=', $endTime);
                    });
            })
            ->exists();

        return $existingSlots;
    }
    // Helper function to check if the provided time slot overlaps with existing ones
    // private function isTimeSlotOverlap($doctorId, $dayNumber, $startTime, $endTime)
    // {
    //     // Calculate the end time for the previous appointment (2 hours before the provided start time)
    //     $prevAppointmentEndTime = date('H:i:s', strtotime($startTime) - (2 * 3600));

    //     // Calculate the start time for the next appointment (2 hours after the provided end time)
    //     $nextAppointmentStartTime = date('H:i:s', strtotime($endTime) + (2 * 3600));

    //     // Check if there's any appointment that overlaps with the provided time slot
    //     $existingSlots = DoctorTime::where('doctor_id', $doctorId)
    //         ->where('day_nu', $dayNumber)
    //         ->where(function ($query) use ($startTime, $endTime, $prevAppointmentEndTime, $nextAppointmentStartTime) {
    //             $query->where(function ($q) use ($startTime, $endTime) {
    //                 // Check if the provided time slot overlaps with the end time of the previous appointment
    //                 $q->where('end_at', '>', $startTime)
    //                     ->where('end_at', '<=', $endTime);
    //             })
    //                 ->orWhere(function ($q) use ($startTime, $endTime, $prevAppointmentEndTime, $nextAppointmentStartTime) {
    //                     // Check if the provided time slot overlaps with the start time of the next appointment
    //                     $q->where('start_at', '>=', $startTime)
    //                         ->where('start_at', '<', $endTime);
    //                 })
    //                 ->orWhere(function ($q) use ($startTime, $endTime, $prevAppointmentEndTime, $nextAppointmentStartTime) {
    //                     // Check if the provided time slot is completely within an existing appointment
    //                     $q->where('start_at', '<=', $startTime)
    //                         ->where('end_at', '>=', $endTime);
    //                 })
    //                 ->orWhere(function ($q) use ($startTime, $endTime, $prevAppointmentEndTime, $nextAppointmentStartTime) {
    //                     // Check if the provided time slot completely contains an existing appointment
    //                     $q->where('start_at', '>=', $startTime)
    //                         ->where('end_at', '<=', $endTime);
    //                 })
    //                 ->orWhere(function ($q) use ($prevAppointmentEndTime, $nextAppointmentStartTime) {
    //                     // Check if there's enough gap between appointments for the provided time slot
    //                     $q->where('end_at', '<', $prevAppointmentEndTime)
    //                         ->orWhere('start_at', '>', $nextAppointmentStartTime);
    //                 });
    //         })
    //         ->exists();

    //     return $existingSlots;
    // }
}
