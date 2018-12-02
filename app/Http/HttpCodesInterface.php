<?php

namespace App\Http;

interface HttpCodesInterface
{
    /**
     * @var int
     */
    public const BAD_REQUEST = 400;

    /**
     * @var int
     */
    public const NOT_FOUND = 404;

    /**
     * @var int
     */
    public const CONFLICT = 409;

    /**
     * @var int
     */
    public const PRECONDITION_FAILED = 412;

    /**
     * @var int
     */
    public const TOO_MANY_REQUESTS = 429;
}
