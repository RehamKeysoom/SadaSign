<?php

namespace App\Http\Requests\Exam;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateExamRequest extends BaseRequest
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
        'lesson_id'=>'required',
        'the_right_choice'=>'required',
        'video_url'=>'required',
        'choose1'=>'required',
        'choose2'=>'required',
        'choose3'=>'required',

        ];
    }

}
