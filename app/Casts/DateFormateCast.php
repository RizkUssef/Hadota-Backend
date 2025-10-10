<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DateFormateCast implements CastsAttributes
{
    // protected $short;
     public function __construct(protected bool $short = false){ }
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $date = Carbon::parse($value);
        if($date->isToday()){ 
            return [
                "date" => "Today",
                "time" => $date->format('h:i A'),
            ];
        }        
        if ($date->isYesterday()) {
            return [
                "date" => "Yesterday",
                "time" => $date->format('h:i A'),
            ];
        }else{
            return [
                "date" => $date->format('D, M j, y'),
                "time" => $date->format('h:i A'),
            ];
        }
    }
    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
