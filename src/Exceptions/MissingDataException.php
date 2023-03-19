<?php

namespace BarnsleyHQ\SimplePush\Exceptions;

class MissingDataException extends \Exception
{
    public function __construct(array|string $field, $code = 0, \Throwable $previous = null)
    {
        if (is_array($field)) {
            $field = implode(', ', $field);
        }

        parent::__construct('Missing SimplePush data: '.$field, $code, $previous);
    }
}
