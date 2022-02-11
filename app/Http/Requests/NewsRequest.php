<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsRequest extends FormRequest
{
    /**
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
     * @return array
     */
    public function rules(): array
    {
        return [
            'category' => 'required|string|in:general,science,sports,business,health,entertainment,tech,politics,food,travel',
            'language' => 'required|string|in:en,ru',
            'limit' => 'required|numeric|max:10|min:1'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'category.required' => 'Category field is required',
            'category.string' => 'Category value must be string',
            'category.in' => 'Category value can be one of [general, science, sports, business, health, entertainment, tech, politics, food, travel]',
            'language.required' => 'Language field is required',
            'language.string' => 'Language value must be string',
            'language.in' => 'Language value can be either en or ru',
            'limit.required' => 'Limit field is required',
            'limit.numeric' => 'Limit value must be integer',
            'limit.max' => 'Limit value must be less than 10',
            'limit.min' => 'Limit value must be more than 1'
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errorKey = $validator->errors()->keys()[0];
        $errorValue = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json([
                'error' => [
                    $errorKey => $errorValue
                ]
            ])
        );
    }
}
