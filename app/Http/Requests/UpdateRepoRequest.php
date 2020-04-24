<?php

namespace App\Http\Requests;

use App\Repo;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UpdateRepoNameRule;


class UpdateRepoRequest extends FormRequest
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
        // dd($this->route('repo'));
        // $repo =Repo::find($this->route('repo'));
        $repo = $this->route('repo');
        // dd($repo);
        return [
            'name' => ['required', new UpdateRepoNameRule($repo)],
            'tags' => ['nullable','max:10']
        ];
    }
}
