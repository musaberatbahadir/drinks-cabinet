<?php


spl_autoload_register(function ($class_name) {
    if ($class_name !== 'Shelf') {
        require_once 'helpers/' . $class_name . '.php';
    } else {
        require_once 'Shelf.php';
    }
});

class Cabinet
{
    private $shelves = [];
    private $doorState;
    private $totalCanCount = 0;
    private $totalCapacity = 0;

    public function __construct($shelfCount = 3, $shelfCapacity = 20)
    {
        /**
         * There can not be a cabinet which has less than one Shelf Capacity & Shelf Count
         */
        if ($shelfCapacity < 1 || $shelfCount < 1) {
            exit("Logic Error !");
        }

        $this->doorState = new DoorState();

        /**
         * Creates Shelves.
         */
        for ($i = 0; $i < $shelfCount; $i++) {
            array_push($this->shelves, new Shelf($shelfCapacity));
        }

        $this->totalCapacity = $shelfCount * $shelfCapacity;
    }

    /**
     * Adds a Can to Cabinet on available shelf
     */
    public function addCan()
    {
        $this->checkDoorOpenStatus();

        foreach ($this->shelves as $shelf) {
            if ($shelf->isFull()) {
                continue;
            }
            $shelf->addCan();
            $this->totalCanCount++;
            return;
        }
        throw new CabinetException(__FUNCTION__, 1);
    }

    /**
     * Takes a Can from Cabinet on available shelf
     */
    public function takeCan()
    {
        $this->checkDoorOpenStatus();

        foreach (array_reverse($this->shelves) as $shelf) {
            if ($shelf->isEmpty()) {
                continue;
            }
            $shelf->takeCan();
            $this->totalCanCount--;
            return;
        }
        throw new CabinetException(__FUNCTION__, 2);
    }

    /**
     * Returns Door State as Readable
     */
    public function getReadableOpenStatus()
    {
        return $this->doorState->getReadableState();
    }

    /**
     * Opens Cabinet Door if it is not already opened
     */
    public function openDoor()
    {
        if ($this->doorState->isOpen()) {
            throw new CabinetException(__FUNCTION__, 3);
        }
        $this->doorState->open();
    }

    /**
     * Closes Cabinet Door if it is not already closed
     */
    public function closeDoor()
    {
        if ($this->doorState->isClosed()) {
            throw new CabinetException(__FUNCTION__, 3);
        }
        $this->doorState->close();
    }

    /**
     * Returns Below information
     *  - Cabinet Status
     *  - Total existed Can count
     *  - Available place count in Cabinet
     *  - Total capacity of Cabinet
     * as a Cabinet Place Report
     */
    public function getCabinetPlaceReport()
    {
        $cabinetStatus = $this->getCabinetStatusText();

        return "\t" . $cabinetStatus .
            "\nTotal Can Count: " . $this->totalCanCount .
            "\nAvailable Place: " . ($this->totalCapacity - $this->totalCanCount) .
            "\nTotal Capacity: " . $this->totalCapacity;
    }

    /**
     * Checks Cabinet's Door status for adding or taking a can from cabinet
     */
    private function checkDoorOpenStatus()
    {
        if (!$this->doorState->isOpen()) {
            throw new CabinetException(__METHOD__, 0);
        }
    }

    /**
     * Returns Cabinets Full or Empty or Partial Filled status
     */
    private function getCabinetStatusText()
    {
        foreach ($this->shelves as $key => $shelf) {
            if ($shelf->isEmpty() && $key === 0) {
                return "Empty";
            } else {
                if ($shelf->isFull() && $key === count($this->shelves) - 1) {
                    return "Full";
                } else {
                    continue;
                }
            }
        }
        return "Partial Filled";
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }
}