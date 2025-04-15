<?php

namespace LeonardoHipolito\LaravelLogDb\Support;

use Illuminate\Support\Carbon;

class DatabaseDateIntervalNameResolver
{
    public static function make(): static
    {
        return new static();
    }

    public function daily(): string
    {
        return Carbon::now()->format("Y-m-d")."-logs.sqlite";
    }

    public function weekly(): string
    {
        return Carbon::now()->format("Y-W")."-logs.sqlite";
    }
    public function monthly(): string
    {
        return Carbon::now()->format("Y-m")."-logs.sqlite";
    }
    public function yearly(): string
    {
        return Carbon::now()->format("Y")."-logs.sqlite";
    }
    public function hourly(): string
    {
        return Carbon::now()->format("Y-m-d H")."-logs.sqlite";
    }

}
