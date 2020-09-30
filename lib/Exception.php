<?php
namespace OpenNode;
class Exception
{
    public static function formatError($http_status, $error)
    {
        $message = '';

        if (isset($error['reason']))
            $reason = $error['reason'];

        if (isset($error['error']))
            $message = $error['error'];

        if (isset($error['message']))
            $message = $error['message'];

        return $http_status . ' - ' . $message;
    }

    public static function throwException($http_status, $error)
    {
        $reason = $error['message'];

        switch ($http_status) {
            case 400:
              throw new \OpenNode\BadRequest(self::formatError($http_status, $error));
            case 401:
              throw new \OpenNode\Unauthorized(self::formatError($http_status, $error));
            case 404:
              throw new \OpenNode\NotFound(self::formatError($http_status, $error));
            case 422:
              throw new \OpenNode\UnprocessableEntity(self::formatError($http_status, $error));
            case 429:
              throw new \OpenNode\RateLimitException(self::formatError($http_status, $error));
            case 500:
              throw new \OpenNode\InternalServerError(self::formatError($http_status, $error));
            default: throw new \OpenNode\APIError(self::formatError($http_status, $error));
        }
    }
}
