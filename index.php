<?php

// calls tests
include 'tests/test.php';
require_once 'src/Cabinet.php';
require_once 'src/Option.php';

welcomeMessage();

/**
 * Initializes a new Cabinet
 * As Default there exists 3 Shelf and each Shelf's capacity is 20
 */
$cabinet = Cabinet::create(3, 20);

/**
 * Creates Option class which will be handle user's input taken by readline
 */
$option = new Option($cabinet);

while (1) {
    assistanceMessage();
    $option->handle(readline());
}

// prints a welcome message for user
function welcomeMessage()
{
    $textSeperator = str_repeat("*", 10);

    print <<<END
    
    Welcome to the Beverages Cabinet!
    
    $textSeperator RULES $textSeperator 
        |
        | - Createad Beverages Cabinet has 3 shelves and each shelf can contain 20 cans on default declaration.
        |
        | - You are able to learn Cabinet status in each step.
        |
        | - You are able to add or take a can to/from Cabinet if and only if Cabinet door is open.
        |
        | - You are able to add or take a can to/from Cabinet.
        |
        | - You should type '0' to quit on application !!
        |
     $textSeperator RULES $textSeperator
     
     
     Let's Get Started !!
     
END;
}

// prints available options to user as user manual
function assistanceMessage()
{
    print <<<END
    
    I'm your assistant and I'm going to ask what you want to do you in each step.
    |
    | - Type '0' to quit on application !!
    |
    | - Type '1' to add a can to Cabinet
    |
    | - Type '2' to take a can from Cabinet
    | 
    | - Type '3' to learn Cabinet Open Status
    |
    | - Type '4' to open Cabinet Door
    |
    | - Type '5' to close Cabinet Door
    |
    | - Type '6' to get Total Place Report
    |


END;
}