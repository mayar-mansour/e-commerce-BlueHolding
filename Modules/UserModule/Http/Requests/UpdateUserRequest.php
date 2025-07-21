<?php

namespace Modules\UserModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\UserModule\Services\UserService;

class UpdateUserRequest extends FormRequest
{

    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    $is_email_not_unique = $this->userService->checkUserEmail(
                        $value,
                        $this->id
                    );
                    if ($is_email_not_unique) {
                        return $fail(
                            __(
                                'messages.this_email_is_already_in_used'
                            )
                        );
                    }
                },
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
