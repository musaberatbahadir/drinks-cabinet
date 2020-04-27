<?php


final class DoorState
{
    const CLOSED = 0;
    const OPEN = 1;
    private $state;

    public function __construct()
    {
        $this->state = self::CLOSED;
    }

    /**
     * Changes door state as open
     */
    public function open()
    {
        $this->state = self::OPEN;
    }

    /**
     * Changes door state as closed
     */
    public function close()
    {
        $this->state = self::CLOSED;
    }

    /**
     * Checks door state Open status
     */
    public function isOpen()
    {
        return $this->state === self::OPEN;
    }

    /**
     * Checks door state Closed status
     */
    public function isClosed()
    {
        return $this->state === self::CLOSED;
    }

    /**
     * Returns Door status in readable format
     */
    public function getReadableState()
    {
        return $this->isOpen() ? "Open" : "Closed";
    }
}