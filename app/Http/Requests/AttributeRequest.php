<?php

namespace App\Http\Requests;

use App\Rules\UniqueAttributeName;
use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class AttributeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => ['required', new UniqueAttributeName($this->name)]
            'name' => 'required|unique:attribute_translations,name,' . $this-> id,
        ];
    }
}
