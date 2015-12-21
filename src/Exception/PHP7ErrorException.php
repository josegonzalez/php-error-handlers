<?php
namespace Josegonzalez\ErrorHandlers\Exception;

use Exception;

/**
 * Wraps a PHP 7 Error object inside a normal Exception
 * so it can be handled correctly by the rest of the
 * error handling system
 *
 */
class PHP7ErrorException extends Exception
{

    /**
     * The wrapped error object
     *
     * @var Error
     */
    protected $error;

    /**
     * Wraps the passed Error class
     *
     * @param Error $error the Error object
     */
    public function __construct($error)
    {
        $this->error = $error;
        $message = $error->getMessage();
        $code = $error->getCode();
        parent::__construct(sprintf('(%s) - %s', get_class($error), $message), $code);
    }

    /**
     * Returns the wrapped error object
     *
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }
}
