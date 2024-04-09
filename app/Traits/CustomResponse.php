<?php

namespace App\Traits;

trait CreateResponse
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

    public function __construct()
    {
        // The constructor is not the best place to set translations based on locale.
        // Instead, do this in the create_response method where the locale is more reliably set.
    }

    function create_response(bool $success, string $message = '', $data = "", $status = 200)
    {
        $statusMessage = $this->jsonResponses[$status] ?? 'Something went wrong, please reload the page and try again';

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
                'status' => $status,
                'status_message' => $statusMessage,
            ],
            $status
        );
    }
}
