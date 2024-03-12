<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create default response success
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($data = null, $message = 'success', $code = Response::HTTP_OK)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * Create default response failed
     *
     * @param mixed $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function oops($message = '', $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => null
        ], $code);
    }

    /**
     * Create default response invalid input
     *
     * @param array<mixed> $errors
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalid($errors = [], $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'code'    => $code,
            'message' => 'Unprocessable Entities',
            'errors'  => $errors,
        ], $code);
    }

    /**
     *
     * @param   ?String  $string
     * @return  String
     */
    public function stringToCrypt($string)
    {
        if (!is_null($string)) {
            return Crypt::encryptString($string);
        }
        return '';
    }

    /**
     *
     * @param   String  $crypt
     * @return  String
     */
    public function cryptToString($crypt)
    {
        try {
            return Crypt::decryptString($crypt);
        } catch (DecryptException $e) {
            return back()->withErrors([
                'message' => $e->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
