<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Class ApiController
 * @package App\Modules\Api\Lesson\Controllers
 */
class ApiController extends Controller
{
    public function responseSuccessCreate($data = [])
    {
        return response([
            'status'  => 'success',
            'message' => 'Successfully Saved',
            'code'    => 200,
            'data'    => $data,
        ], 200);
    }

    public function responseSuccessUpdate()
    {
        return response([
            'status'  => 'success',
            'message' => 'Successfully Updated',
            'code'    => 200,
        ], 200);
    }

    public function responseSuccessDelete()
    {
        return response([
            'status'  => 'success',
            'message' => 'Successfully Deleted',
            'code'    => 200,
        ], 200);
    }

    public function response($status, $message, $code)
    {
        return response([
            'status'  => $status,
            'message' => $message,
            'code'    => $code,
        ], $code);
    }

    public function responseWithData($data)
    {
        return response([
            'status'  => 'success',
            'message' => 'Data Fetched',
            'code'    => 200,
            'data'    => $data,
        ], 200);
    }
}