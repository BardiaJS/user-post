<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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


            if(auth('sanctum')->user()->is_super_admin == 0){
                return [
                    'first_name' => 'required|max:10' ,
                    'last_name' => 'required|max:10' ,
                    'display_name' =>'required|max:10' ,
                    'email' => 'required|email|unique:users,email' ,
                    'is_admin' => 'sometimes|boolean'
                ];
            }else{
                return [
                    'first_name' => 'required|max:10' ,
                    'last_name' => 'required|max:10' ,
                    'display_name' =>'required|max:10' ,
                    'email' => 'required|email|unique:users,email' ,
                    'is_admin' => 'reqiured|boolean'
                ];
            }
        }
    }

