<?php

require_once 'ResponseType.php';

trait OutputActions
{
    /**
     * Prints given output
     */
    private function printOutput($output)
    {
        echo $output;
    }

    /**
     * Calls printOutput function with new line and color ending string
     */
    private function printWithNewLine($output)
    {
        $this->printOutput("\n" . $output . "\033[0m\n");
    }

    /**
     * Calls printWithNewLine function with Error Color
     */
    private function printError($output)
    {
        $this->printWithNewLine(ResponseType::ERROR . $output);
    }

    /**
     * Calls printWithNewLine function with Success Color
     */
    private function printSuccess($output)
    {
        $this->printWithNewLine(ResponseType::SUCCESS . $output);
    }

    /**
     * Calls printWithNewLine function with Info Color
     */
    private function printInfo($output)
    {
        $this->printWithNewLine(ResponseType::INFO . $output);
    }
}