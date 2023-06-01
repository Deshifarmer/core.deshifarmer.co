<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BaseController extends Controller
{
    protected $perPage;
    //    global veriable for all the controller
    public function __construct()
    {
        $this->perPage = 10;
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [

            'success' => true,
            'data'    => $result,
            'message' => $message,
            'code' => 200
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code' => 404

        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function myPaginator(Collection $collection)
    {
        $page = request()->get('page', 1); // the current page number (default to 1)

        $paginatedData = $collection->slice(($page - 1) * $this->perPage, $this->perPage)->all();

        $paginatedCollection = new LengthAwarePaginator(
            $paginatedData, // the current page of data
            $collection->count(), // the total number of items in the collection
            $this->perPage, // the number of items per page
            $page, // the current page number
            ['path' => request()->url()] // additional query string parameters
        );
        return $paginatedCollection;
    }

    public function generateUUID()
    {
        $uuid = substr(Str::uuid(), 4, 8);
        return $uuid;
    }
}
