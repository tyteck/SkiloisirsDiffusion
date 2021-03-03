<?php

namespace SkiloisirsDiffusion\Exceptions;

use Exception;

class SLDServiceNotAvailableException extends Exception
{
    protected $message = 'SLD service is not available, repeat your request later.';
}
