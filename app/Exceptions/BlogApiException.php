<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as Http;
use Throwable;

class BlogApiException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
     public function report()
     {
        Log::error('EXCEPTION: '.static::class.' FILE: '.$this->getPrevious()->getFile().' LINE: '.$this->getPrevious()->getLine().' -- '.$this->getMessage());
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'errors' => $this->message,
         ])
            ->setStatusCode(static::getCode());
    }
}
