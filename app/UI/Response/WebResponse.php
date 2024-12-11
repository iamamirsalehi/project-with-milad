<?php

namespace App\UI\Response;

use Symfony\Component\HttpFoundation\Response;

class WebResponse
{
    private const SUCCESS_MESSAGE_KEY = 'success';
    private const FAILED_MESSAGE_KEY = 'failed';

    public static function backFailed(string $message = '')
    {
        return redirect()->back()->with(self::FAILED_MESSAGE_KEY, $message);
    }

    public static function backSuccess(string $message = '')
    {
        return redirect()->back()->with(self::SUCCESS_MESSAGE_KEY, $message);
    }

    public static function view(string $address, array $data = [])
    {
        return view($address, $data);
    }

    public static function redirectCreated(string $toRoute, string $message = '')
    {
        return redirect()->to($toRoute)->setStatusCode(Response::HTTP_CREATED)->with(self::SUCCESS_MESSAGE_KEY, $message);
    }

    public static function redirectSuccess(string $toRoute, string $message = '')
    {
        return redirect()->to($toRoute)->setStatusCode(Response::HTTP_OK)->with(self::SUCCESS_MESSAGE_KEY, $message);
    }

    public static function redirectFailed(string $toRoute, string $message = '')
    {
        return redirect()->to($toRoute)->setStatusCode(Response::HTTP_BAD_REQUEST)->with(self::FAILED_MESSAGE_KEY, $message);
    }
}
