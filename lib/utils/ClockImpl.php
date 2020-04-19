<?php


namespace lib\utils;


/**
 * The default implementation that simply uses `time()` to get the current timestamp.
 */
class ClockImpl implements Clock
{

    public function getCurrentTimestamp(): int
    {
        return time();
    }
}