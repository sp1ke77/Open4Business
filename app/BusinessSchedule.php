<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessSchedule extends Model
{
    use SoftDeletes;

    protected $appends = ['type_string'];

    private static $type_strings = [
        'Forças de Segurança, Entidades de Proteção Civil e Profissionais de Saúde',
        'Idosos / Maiores de 65 anos / Grupo de Risco',
        'Público Geral',
    ];

    public static function getTypeNumberFromString($type)
    {
        $type = \array_search($type, BusinessSchedule::$type_strings, true);
        if($type == -1) {
            $type = 0;
        }
        return $type;
    }

    public static function getTypeStringFromNumber($type)
    {
        return BusinessSchedule::$type_strings[$type];
    }

    public static function createSchedule($business_id,$start_hour,$end_hour,$sunday,$monday,$tuesday,$wednesday,$thrusday,$friday,$saturday,$type) {
        if (\gettype($type) == "string") {
            $type = BusinessSchedule::getTypeNumberFromString($type);
        }
        $business_schedule = new BusinessSchedule();
        $business_schedule->business_id = $business_id;
        $business_schedule->start_hour = $start_hour;
        $business_schedule->end_hour = $end_hour;
        $business_schedule->sunday = $sunday;
        $business_schedule->monday = $monday;
        $business_schedule->tuesday = $tuesday;
        $business_schedule->wednesday = $wednesday;
        $business_schedule->thrusday = $thrusday;
        $business_schedule->friday = $friday;
        $business_schedule->saturday = $saturday;
        $business_schedule->type = $type;
        $business_schedule->save();
        return $business_schedule;
    }

    public function business() {
        return $this->belongsTo(Business::class);
    }

    public function getTypeStringAttribute() {
        return BusinessSchedule::getTypeStringFromNumber($this->type);
    }

    public function updateStartHour($start_hour)
    {
        $this->start_hour = $start_hour;
        $this->save();
    }

    public function updateEndHour($end_hour)
    {
        $this->end_hour = $end_hour;
        $this->save();
    }

    public function updateSunday($sunday)
    {
        $this->sunday = $sunday;
        $this->save();
    }

    public function updateMonday($monday)
    {
        $this->monday = $monday;
        $this->save();
    }

    public function updateTuesday($tuesday)
    {
        $this->tuesday = $tuesday;
        $this->save();
    }

    public function updateWednesday($wednesday)
    {
        $this->wednesday = $wednesday;
        $this->save();
    }

    public function updateThursday($thrusday)
    {
        $this->thrusday = $thrusday;
        $this->save();
    }

    public function updateFriday($friday)
    {
        $this->friday = $friday;
        $this->save();
    }

    public function updateSaturday($saturday)
    {
        $this->saturday = $saturday;
        $this->save();
    }

    public function updateType($type)
    {
        if (\gettype($type) == "string") {
            $type = BusinessSchedule::getTypeNumberFromString($type);
        }
        $this->type = $type;
        $this->save();
    }
}
