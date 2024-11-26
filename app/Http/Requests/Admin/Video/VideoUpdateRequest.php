<?php

namespace App\Http\Requests\Admin\Video;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 * @property string $url
 * @property int $status
 */
class VideoUpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validation=[
            'title' => 'required|array',
            'title.*' => 'nullable|string|min:1|max:191',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string|min:1|max:1000',
            'type' => 'required|'.Rule::in(['1', '2'])
        ];

        if ($this->type=='2') {
            $validation['url']='nullable|string|url';
            $validation['video']='required|file';
        } else {
            $validation['url']='required|string|url';
            $validation['video']='nullable|file';
        }

        return $validation;
    }

    public function messages(): array
    {
        return [
            'title.required' => translate('the_title_field_is_required'),
            'url.required' => translate('the_url_is_required'),
            'video.required' => translate('the_video_is_required'),
        ];
    }

}
