<?php


namespace App\Http\Requests;

use App\Foundation\Modules\FormRequest\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected $routeName;

    public function __construct()
    {
        $this->routeName = current_route_name();
    }

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        if ($validator->fails()) {
            $details = [];
            foreach ($errors as $key => $error) {
                $details[$key] = Arr::first($error);
            }
            $response = [
                'code'    => 404,
                'message' => Arr::first($errors)[0],
                'details' => (object)$details,
            ];
            $response = response()->json($response, Response::HTTP_PAYMENT_REQUIRED, []);
            throw new HttpResponseException($response);
        }
    }
}