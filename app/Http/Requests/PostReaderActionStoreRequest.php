<?php

namespace App\Http\Requests;

use App\Action;
use Illuminate\Foundation\Http\FormRequest;

class PostReaderActionStoreRequest extends FormRequest
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
        $rules=[
            'type'  =>  'required|in:' . Action::ACTION_COMMENT .','. Action::ACTION_REACTION .','. Action::ACTION_SCORE,
        ];
        if($this->request->get('type') == Action::ACTION_SCORE){
            $rules['content']='required|in:'. implode(',', Action::SCORES);
        }else if($this->request->get('type') == Action::ACTION_REACTION){
            $rules['content']='required|in:'. implode(',', Action::REACTION);
        }else{
            $rules['content']='required|min:2';
        }

        return $rules;
    }

    public function messages()
    {
        $rules =[
            'type.required'     =>  'El :attribute es obligatorio',
            'type.in'           =>  'El :attribute no es válido',
        ];
        if($this->request->get('type') == Action::ACTION_SCORE){
            $rules['content.in']='El :attribute debe contener un valor del 1 al 5';
        }
        if($this->request->get('type') == Action::ACTION_REACTION){
            $rules['content.in']='El :attribute debe contener una reaccion válida';
        }
        return $rules;
    }
}
