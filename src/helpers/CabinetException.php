<?php


class CabinetException extends Exception
{
    /**
     * Returns related special error message by given errorCode
     */
    public function getErrorText()
    {
        return [
            0 => "You have to open cabinet door !",
            1 => "All Shelves are full, You should take a Can before adding new one !",
            2 => "There is no Can left! You should add a can to Cabinet !",
            3 => "The door is already open !",
            4 => "The door is already closed !",
        ][$this->getCode()];
    }
}