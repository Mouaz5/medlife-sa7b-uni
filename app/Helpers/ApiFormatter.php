<?php

namespace App\Helpers;

class ApiFormatter
{
    /**
     * HTTP status codes
     */
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_VALIDATION_ERROR = 422;
    public const HTTP_SERVER_ERROR = 500;

    /**
     * Format API response
     *
     * @param bool $isError Whether this response represents an error
     * @param int|string $status HTTP status code or status message
     * @param string $message Response message
     * @param mixed $data Response data (optional)
     * @return array Formatted response array
     */
    public static function format(bool $isError, $status, string $message, $data = null): array
    {
        $result = [
            'success' => !$isError,
            'status' => $status,
            'message' => $message,
        ];

        if (!$isError && $data !== null) {
            $result['data'] = $data;
        }

        return $result;
    }

    /**
     * Create a success response
     *
     * @param string $message Success message
     * @param mixed $data Response data (optional)
     * @param int $status HTTP status code (default: 200)
     * @return array Formatted success response
     */
    public static function success(string $message, $data = null, $status = self::HTTP_OK): array
    {
        return self::format(false, $status, $message, $data);
    }

    /**
     * Create an error response
     *
     * @param string $message Error message
     * @param int $status HTTP status code (default: 400)
     * @param mixed $data Additional error data (optional)
     * @return array Formatted error response
     */
    public static function error(string $message, $status = self::HTTP_BAD_REQUEST, $data = null): array
    {
        return self::format(true, $status, $message, $data);
    }

    /**
     * Create a validation error response
     *
     * @param string $message Validation error message
     * @param array $errors Validation errors
     * @return array Formatted validation error response
     */
    public static function validationError(string $message, array $errors): array
    {
        return self::error($message, self::HTTP_VALIDATION_ERROR, ['errors' => $errors]);
    }

    /**
     * Create a not found error response
     *
     * @param string $message Not found message
     * @return array Formatted not found response
     */
    public static function notFound(string $message = 'Resource not found'): array
    {
        return self::error($message, self::HTTP_NOT_FOUND);
    }

    /**
     * Legacy method for backward compatibility
     *
     * @deprecated Use format() instead
     * @param bool $is_error Whether this response represents an error
     * @param int|string $status HTTP status code or status message
     * @param string $message Response message
     * @param mixed $data Response data (optional)
     * @return array Formatted response array
     */
    public static function SendResponses($is_error, $status, $message, $data = null): array
    {
        return self::format($is_error, $status, $message, $data);
    }
}
