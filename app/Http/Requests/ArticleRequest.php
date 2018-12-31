<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'en_title' => 'required_without:es_title',
            'en_body' => 'required_without:es_body',

            'es_title' => 'required_without:en_title',
            'es_body' => 'required_without:en_body',

            'category_id' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'en_title.required_without' => 'Please enter the english blog title',
            'en_body.required_without' => 'Please enter the english blog body',
            'es_title.required_without' => 'Please enter the spanish blog title',
            'es_body.required_without' => 'Please enter the spanish blog body',
            'category_id.required' => 'Please select category for the blog',
        ];
    }
}
