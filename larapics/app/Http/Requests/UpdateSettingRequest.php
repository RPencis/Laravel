<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'social.*' => 'nullable|url',
            'options.disable_comments' => 'boolean',
            'options.moderate_comments' => 'boolean',
            'options.email_notification.*' => 'nullable'
        ];
    }

    public function attributes(){
        return [
            'social.facebook' => 'facebook',
            'social.twitter' => 'twitter',
            'social.instagram' => 'instagram',
            'social.website' => 'website'
        ];
    }

    public function getData(){
        return $this->validated();
    }
}
