<?php

namespace Src\Helpers;

class Time
{
    private float $begin_time;

    private float $end_time;

    public function startTime(): void
    {
        $this->begin_time = microtime(true);
    }

    public function endTime(): void
    {
        $this->end_time = microtime(true);
    }

    public function elapsedTime(int $precision = 10): string
    {
        return number_format(($this->end_time - $this->begin_time), $precision);
    }

    public function blockAvg(int $block_size, int $precision = 10): string
    {
        return number_format(($this->elapsedTime() / $block_size), $precision);
    }
}
