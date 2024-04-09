<?php

namespace App\Traits;

trait CustomResponse
{
    protected $jsonResponses = [
        100 => "Continue",
        200 => "Successfully Get Data",
        201 => "Created Successfully",
        202 => "Updated Successfully",
        203 => "Deleted Successfully",
        403 => "Forbidden",
        404 => "Not Found",
    ];

    function create_response(string $message = '', $data = "", $status = 200)
    {
        $statusMessage = $this->jsonResponses[$status] ?? 'Something went wrong, please reload the page and try again';

        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $data,
                'status' => $status,
                'status_message' => $statusMessage,
            ],
            $status
        );
    }

    function error_response(string $message = '', $error = "", $status = 200)
    {
        $statusMessage = $this->jsonResponses[$status] ?? 'Something went wrong, please reload the page and try again';

        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'error' => $error,
                'status' => $status,
                'status_message' => $statusMessage,
            ],
            $status
        );
    }
}
