<?php


spl_autoload_register(function ($class_name) {
    if ($class_name !== 'Cabinet') {
        require_once 'helpers/' . $class_name . '.php';
    } else {
        require_once 'Cabinet.php';
    }
});

class Option
{
    use OutputActions;

    const QUIT_APPLICATION = '0';
    const CABINET_ADD = '1';
    const CABINET_TAKE = '2';
    const CABINET_DOOR_STATUS = '3';
    const CABINET_DOOR_OPEN = '4';
    const CABINET_DOOR_CLOSE = '5';
    const CABINET_PLACE_REPORT = '6';

    const AVAILABLE_OPTIONS = [
        self::QUIT_APPLICATION,
        self::CABINET_ADD,
        self::CABINET_TAKE,
        self::CABINET_DOOR_STATUS,
        self::CABINET_DOOR_OPEN,
        self::CABINET_DOOR_CLOSE,
        self::CABINET_PLACE_REPORT,
    ];

    private $cabinet;

    public function __construct(Cabinet $cabinet)
    {
        $this->cabinet = $cabinet;
    }

    /**
     * Handles user's input with respect to Cabinet actions
     * Prints those actions with related color
     */
    public function handle($value)
    {
        if (!in_array($value, self::AVAILABLE_OPTIONS)) {
            $this->printError("Type A Valid Number!!");
        }

        try {
            $response = $this->responseAction($value);
            if (isset($response)) {
                $this->printInfo($response);
            } else {
                $this->printSuccess("Done.");
            }
        } catch (CabinetException $exception) {
            $this->printError($exception->getErrorText());
        }
    }

    public function responseAction($value)
    {
        switch ($value) {
            case self::QUIT_APPLICATION:
                exit("Good Bye...\n");
            case self::CABINET_ADD:
                return $this->cabinet->addCan();
            case self::CABINET_TAKE:
                return $this->cabinet->takeCan();
            case self::CABINET_DOOR_STATUS:
                return $this->cabinet->getReadableOpenStatus();
            case self::CABINET_DOOR_OPEN:
                return $this->cabinet->openDoor();
            case self::CABINET_DOOR_CLOSE:
                return $this->cabinet->closeDoor();
            case self::CABINET_PLACE_REPORT:
                return $this->cabinet->getCabinetPlaceReport();
        }
    }
}