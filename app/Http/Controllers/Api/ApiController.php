<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as Http;

class ApiController extends Controller
{
    protected $statusCode = Http::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return ApiController
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(Http::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(Http::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function respond($data, $headers = [])
    {
        if (is_subclass_of($data,  ResourceCollection::class)) {

            return $data->response()->setStatusCode($this->getStatusCode());

        }

        // TODO: See about eliminating this.
        return Response::json([
            'data' => $data
            ], $this->getStatusCode(), $headers);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respondCreated($message = 'Created Successfully.')
    {
        return $this->setStatusCode(Http::HTTP_CREATED)->respond(['message' => $message]);
    }

    public function respondDestroyed($message = 'Destroyed Successfully.')
    {
        return $this->setStatusCode(Http::HTTP_NO_CONTENT)->respond(['message' => $message]);
    }

}