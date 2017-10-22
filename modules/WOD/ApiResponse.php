<?php

namespace Apine\Modules\WOD;

class ApiResponse {

    public $version = "1.5";

    public $code;

    public $response;

    public $message;

    public $queryTime;

    public $executionMilliseconds;

    public $endpointCalls;

}