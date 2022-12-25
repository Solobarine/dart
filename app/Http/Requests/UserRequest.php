<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
          'first_name' => 'required|min:2',
          'last_name' => 'required|min:2',
          'email' => 'required|email',
          'password' => 'required|min:8|max:25',
          'phone_no' => 'required|min:10',
          'country' => 'required',
          'city' => 'required',
          'address' => 'required',
          'date_of_birth' => 'required|date_format:m/d/Y',
          'gender' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'first_name.required' => 'Please Enter Your First Name',
          'first_name.min' => 'Your Name should be longer than 1 Character',
          'last_name.required' => 'Please Enter Your Last Name',
          'last_name.min' => 'Your Last Name should be longer that 1 Character',
          'email.required' => 'An Email is required',
          'email.email' => 'Your Email is Invalid',
          'password.required' => 'A Password is required',
          'password.min' => 'Password should be longer than 7 Characters',
          'password.max' => 'Password should be at most 25 Characters',
          'phone_no.required' => 'Invalid Phone Number',
          'phone_no.min' => 'Phone Number should be 10 Characters long',
          'country' => 'Please Select Your Country of Origin',
          'city' => 'Please Enter Your City of Residence',
          'address' => 'Please Enter Your Residential Address',
          'date_of_birth.required' => 'Enter Your Date of Birth',
          'date_of_birth.date_format' => 'Invalid Date or Format',
          'gender' => 'Please Enter Your Preferred Gender Identity'
        ];
    }
}
