<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    // 下記二つ追加（FormRequestバリデーション）
    public function rules()
    {
        return [
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'under_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'],
            'mail_address' => ['required', 'string', 'email', 'max:100', 'unique:users,mail_address'],
            'sex' => ['required', Rule::in([1, 2, 3])], // 1:男性, 2:女性, 3:その他
            'old_year' => ['required'],
            'old_month' => ['required'],
            'old_day' => ['required'],
            'role' => ['required', Rule::in([1, 2, 3, 4])], // 1〜3:講師, 4:生徒
            'password' => ['required', 'string', 'between:8,30', 'confirmed'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $year = $this->input('old_year');
            $month = $this->input('old_month');
            $day = $this->input('old_day');

            if (!checkdate((int)$month, (int)$day, (int)$year)) {
                $validator->errors()->add('birth_day', '正しい日付を入力してください。');
            } else {
                $birth_date = \Carbon\Carbon::create($year, $month, $day);
                $min_date = \Carbon\Carbon::create(2000, 1, 1);
                $max_date = now();
                if ($birth_date->lt($min_date) || $birth_date->gt($max_date)) {
                    $validator->errors()->add('birth_day', '2000年1月1日から今日までの範囲で指定してください。');
                }
            }
        });
    }
}
