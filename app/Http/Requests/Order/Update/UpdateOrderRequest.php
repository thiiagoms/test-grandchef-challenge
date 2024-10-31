<?php

namespace App\Http\Requests\Order\Update;

use App\Http\Requests\Order\BaseOrderRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends BaseOrderRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
