<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message, $result = [])
    {
    	$response = [
            'status' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, ResponseHTTP::HTTP_OK);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 422)
    {
    	$response = [
            'status' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

       /**
     * handle all type of exceptions
     * @param \Exception $ex
     * @return mixed|string
     */
    public function handleAndResponseException(\Exception $ex)
    {
        $response = '';
        switch (true) {
            case $ex instanceof ModelNotFoundException:
                $response = response()->json(['message' => $ex->getMessage()], ResponseHTTP::HTTP_NOT_FOUND);
                break;
            case $ex instanceof QueryException:
                $response = response()->json(['message' => $ex->getMessage()], ResponseHTTP::HTTP_BAD_REQUEST);
                break;
            case $ex instanceof HttpResponseException:
                $response = response()->json(['message' => $ex->getMessage()], ResponseHTTP::HTTP_INTERNAL_SERVER_ERROR);
                break;
            case $ex instanceof \Exception:
                $response = response()->json(['message' => $ex->getMessage()], ResponseHTTP::HTTP_INTERNAL_SERVER_ERROR);
                break;
        }
        return $response;
    }
}
