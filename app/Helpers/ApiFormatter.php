<?php

namespace App\Helpers;

class ApiFormatter
{
    public static function SendResponses($is_error, $status, $message, $data)
    {
        $result = [];
        if ($is_error) {
            $result['success'] = false;
            $result['message'] = $message;
            $result['status'] = $status;
        } else {
            $result['success'] = true;
            $result['status'] = $status;
            if ($data == null) {
                $result['message'] = $message;
            } else {
                $result['data'] = $data;
            }
        }
        return $result;
    }
}
