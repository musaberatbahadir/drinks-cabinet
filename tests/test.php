<?php


require_once __DIR__ . '/../src/Cabinet.php';
require_once __DIR__ . '/../src/helpers/CabinetException.php';

$GLOBALS['testCount'] = 0;
$GLOBALS['unsuccessfulTest'] = 0;

foreach (get_defined_functions()['user'] as $testFunction) {
    if (strpos($testFunction, 'test', -4) !== false) {
        $result = $testFunction();
        calculateSummary($result);
    }
}
printResult();

function a_cabinet_door_is_closed_on_initial_position_test()
{
    $cabinet = Cabinet::create();
    $doorStatus = $cabinet->getReadableOpenStatus();

    return assert(
        $doorStatus === "Closed",
        "The Door must be closed on initial position"
    );
}

function can_not_add_a_can_when_cabinet_is_closed_test()
{
    $cabinet = Cabinet::create();

    try {
        $cabinet->addCan();
        return assert(false, "The Door must be closed on initial position");
    } catch (CabinetException $exception) {
        return assert(
            $exception->getCode() === 0 && $cabinet->getReadableOpenStatus() === "Closed",
            "A Can cannot be added while cabinet door is closed"
        );
    }
}

function can_not_take_a_can_when_cabinet_is_closed_test()
{
    $cabinet = Cabinet::create();

    try {
        $cabinet->takeCan();
        return assert(
            false,
            "The Door must be closed on initial position"
        );
    } catch (CabinetException $exception) {
        return assert(
            $exception->getCode() === 0 && $cabinet->getReadableOpenStatus() === "Closed",
            "A Can cannot be added while cabinet door is closed"
        );
    }
}

function add_only_one_can_to_cabinet_test()
{
    $cabinet = Cabinet::create();
    $beforeAddingOneCanReport = $cabinet->getCabinetPlaceReport();

    $cabinet->openDoor();
    $cabinet->addCan();

    $afterAddingOneCanReport = $cabinet->getCabinetPlaceReport();

    return assert(
        strpos($beforeAddingOneCanReport, "Total Can Count: 0") !== false
        &&
        strpos($afterAddingOneCanReport, "Total Can Count: 1") !== false,
        "Only one Can can be added to Cabinet at a time"
    );
}

function take_only_one_can_from_cabinet_test()
{
    $cabinet = Cabinet::create();

    $cabinet->openDoor();
    $cabinet->addCan();
    $beforeTakingOneCanReport = $cabinet->getCabinetPlaceReport();

    $cabinet->takeCan();
    $afterTakingOneCanReport = $cabinet->getCabinetPlaceReport();

    return assert(
        strpos($beforeTakingOneCanReport, "Total Can Count: 1") !== false
        &&
        strpos($afterTakingOneCanReport, "Total Can Count: 0") !== false,
        "Only one Can can be taken from Cabinet at a time"
    );
}

function check_full_status_on_cabinet_test()
{
    $shelfCount = 3;
    $shelfCapacity = 20;

    $cabinet = Cabinet::create(3, 20);
    $cabinet->openDoor();

    for ($addTimes = 0; $addTimes < ($shelfCount * $shelfCapacity); $addTimes++) {
        $cabinet->addCan();
    }

    return assert(
        strpos($cabinet->getCabinetPlaceReport(), "Full") !== false,
        "Cabinet must be full when you fill all shelf"
    );
}

function check_empty_status_on_cabinet_test()
{
    $cabinet = Cabinet::create();

    return assert(
        strpos($cabinet->getCabinetPlaceReport(), "Empty") !== false,
        "Cabinet must be empty on initial position"
    );
}

function check_partial_filled_status_on_cabinet_test()
{
    $shelfCount = 3;
    $shelfCapacity = 20;

    $cabinet = Cabinet::create(3, 20);
    $cabinet->openDoor();

    for ($addTimes = 0; $addTimes < rand(1, $shelfCount * $shelfCapacity - 1); $addTimes++) {
        $cabinet->addCan();
    }

    return assert(
        strpos($cabinet->getCabinetPlaceReport(), "Partial Filled") !== false,
        "Cabinet must be partially filled when add cans random times between max capacity minus 1 and 1"
    );
}

function can_not_add_a_can_when_cabinet_is_full_test()
{
    $shelfCount = 3;
    $shelfCapacity = 20;

    $cabinet = Cabinet::create(3, 20);
    $cabinet->openDoor();

    for ($addTimes = 0; $addTimes < $shelfCount * $shelfCapacity; $addTimes++) {
        $cabinet->addCan();
    }

    try {
        $cabinet->addCan();
        return assert(false, "You can not add a can when cabinet is full");
    } catch (CabinetException $exception) {
        return assert(
            $exception->getCode() === 1,
            "You can not add a can when cabinet is full"
        );
    }
}

function calculateSummary($result)
{
    $GLOBALS['testCount']++;
    if (!$result) {
        $GLOBALS['unsuccessfulTest']++;
    }
}

function printResult()
{
    echo("\n\033[34mTotal Test Count: " . $GLOBALS['testCount'] . "\033[0m\n");
    if ($GLOBALS['unsuccessfulTest'] !== 0) {
        if ($GLOBALS['unsuccessfulTest'] === $GLOBALS['testCount']) {
            echo("\033[31mAll of them failed\033[0m\n");
        } else {
            echo("\033[31m" . $GLOBALS['unsuccessfulTest'] . " of them failed\033[0m\n");
            echo("\033[32m" . $GLOBALS['testCount'] - $GLOBALS['unsuccessfulTest'] . " of them passed\033[0m\n");
        }
        exit;
    } else {
        echo("\033[32mAll of them passed\033[0m\n");
    }
}