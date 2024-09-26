<?php

namespace App\Helpers;

class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
            'description' => null,
            'internal_code' => 2000,
        ],
        'data' => null
    ];

    public static function success($data = null, $message = null, $description = null, $internalCode = null, $code = null)
    {
        if ($code !== null) {
            self::$response['meta']['code'] = $code;
        }
        self::$response['meta']['message'] = $message;
        self::$response['meta']['description'] = $description;
        self::$response['meta']['internal_code'] = $internalCode;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function error($data = null, $message = null, $description = null, $internalCode = null, $code = 400)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['meta']['description'] = $description ?? 'No additional description provided';
        self::$response['meta']['internal_code'] = $internalCode ?? 'No additional internal code provided';
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function errorUserNotHaveRightPermission()
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = 403;
        self::$response['meta']['message'] = "User doesn't have right permission";
        self::$response['meta']['description'] = "You can't access this resource";
        self::$response['data'] = null;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function errorServerError($data)
    {
        self::$response['meta']['status'] = 'Error';
        self::$response['meta']['code'] = 500;
        self::$response['meta']['message'] = 'Something went wrong';
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function mappingErrorMessageToString($errorMessages)
    {
        $arrayMessage = implode(",", $errorMessages);

        return $arrayMessage;
    }
}
