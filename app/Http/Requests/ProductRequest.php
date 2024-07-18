<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
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
        $user=Auth::user();
        // if($user->store){
        //     $store_id=$user->store;
        // }
      
        return [
            'name'=>['required','string','min:3','max:255'],
            'description'=>'nullable|string|max:1000',
            'image'=>['nullable','image','max:4096' ],
            'store_id'=>'min:1',
        ];
    }
}
