<?php

namespace App\Http\Requests\Orders;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'client'                    => 'required',
            'client.id'          => 'exists:clients,id|nullable',
            'client.document_type_id'   => 'required_if:client.id,==,null|nullable|exists:document_types,id',
            'client.document_number'    => 'required_if:client.id,==,null|nullable|numeric',
            'client.name'               => 'required_if:client.id,==,null|nullable',
            'client.last_name'          => 'required_if:client.id,==,null|nullable',
            'client.email'              => 'required_if:client.id,==,null|email|nullable',
            'client.phone'              => 'required_if:client.id,==,null|nullable',
            'products'                  => 'required|array',
            'products.*.id'             => 'required|exists:products,id',
            'products.*.quantity'       => 'required|numeric'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
