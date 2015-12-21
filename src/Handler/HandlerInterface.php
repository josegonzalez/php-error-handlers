<?php
namespace Josegonzalez\ErrorHandlers\Handler;

interface HandlerInterface
{
    /**
     * Handles a given exception
     *
     * @param Throwable|Exception $exception A Throwable or Exception instance
     * @return void
     */
    public function handle($exception);
}
