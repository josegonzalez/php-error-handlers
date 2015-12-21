<?php
namespace Josegonzalez\ErrorHandlers\Exception;

use Exception;

/**
 * Represents a fatal error
 *
 */
class FatalErrorException extends Exception
{

    /**
     * Constructor
     *
     * @param string $message Message string.
     * @param int $code Code.
     * @param string|null $file File name.
     * @param int|null $line Line number.
     */
    public function __construct($message, $code = 500, $file = null, $line = null)
    {
        parent::__construct($message, $code);
        if ($file) {
            $this->file = $file;
        }
        if ($line) {
            $this->line = $line;
        }
    }
}
