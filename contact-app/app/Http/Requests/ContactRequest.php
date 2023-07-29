<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //user doesnt need to be authorized
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50',
            //'first_name' => ['required','string','max:50'],
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    //change the attribute name for form elements
    public function attributes()
    {
        return [
            'company_id' => 'company',
            'email' => 'email address',
        ];
    }

    public function messages()
    {
        return [
            //attribute.rule
            'email.email' => 'The email that you entered is not valid',
            '*.required' => ':attribute cannot be empty',
        ];
    }
    /**
     * This method can be used to modify and to add new data in request if needed
     */
    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'date' => $this->date('date')->format('Y-m-d H:i'),
    //     ]);
    // }
}
