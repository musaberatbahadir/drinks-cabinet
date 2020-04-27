<?php


class Shelf
{
    private $size;
    private $capacity;

    public function __construct($shelfCapacity)
    {
        $this->size = 0;
        $this->capacity = $shelfCapacity;
    }

    /**
     * Increases count of can number on shelf
     */
    public function addCan()
    {
        $this->size++;
    }

    /**
     * Decreases count of can number on shelf
     */
    public function takeCan()
    {
        $this->size--;
    }

    /**
     * Returns Shelf's full status
     */
    public function isFull()
    {
        return $this->getSize() === $this->getCapacity();
    }

    /**
     * Returns Shelf's empty status
     */
    public function isEmpty()
    {
        return $this->getSize() === 0;
    }

    /**
     * Returns Shelf's size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns Shelf's capacity
     */
    public function getCapacity()
    {
        return $this->capacity;
    }
}