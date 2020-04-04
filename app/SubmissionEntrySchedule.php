<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionEntrySchedule extends Model
{
    protected $appends = ['type_string', 'section_of_day_string'];

    protected $fillable = [
        'start_hour',
        'end_hour',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thrusday',
        'friday',
        'saturday',
        'type',
    ];

    public static function createSubmissionEntrySchedule(
        $submission_entry_id,
        $start_hour,
        $end_hour,
        $sunday,
        $monday,
        $tuesday,
        $wednesday,
        $thrusday,
        $friday,
        $saturday,
        $type,
        $section_of_day,
        $by_appointment,
        $by_appointment_contacts
    ) {
        if (\gettype($type) == 'string') {
            $type = BusinessSchedule::getTypeNumberFromString($type);
        }
        if (\gettype($section_of_day) == 'string') {
            $section_of_day = BusinessSchedule::getSectionOfDayNumberFromString($section_of_day);
        }
        $submission_entry_schedule                          = new SubmissionEntrySchedule();
        $submission_entry_schedule->submission_entry_id     = $submission_entry_id;
        $submission_entry_schedule->start_hour              = $start_hour;
        $submission_entry_schedule->end_hour                = $end_hour;
        $submission_entry_schedule->sunday                  = $sunday;
        $submission_entry_schedule->monday                  = $monday;
        $submission_entry_schedule->tuesday                 = $tuesday;
        $submission_entry_schedule->wednesday               = $wednesday;
        $submission_entry_schedule->thrusday                = $thrusday;
        $submission_entry_schedule->friday                  = $friday;
        $submission_entry_schedule->saturday                = $saturday;
        $submission_entry_schedule->type                    = $type;
        $submission_entry_schedule->section_of_day          = $section_of_day;
        $submission_entry_schedule->by_appointment          = $by_appointment;
        $submission_entry_schedule->by_appointment_contacts = $by_appointment_contacts;
        $submission_entry_schedule->save();

        return $submission_entry_schedule;
    }

    public function entry()
    {
        return $this->belongsTo(SubmissionEntry::class, 'submission_entry_id', 'id');
    }

    public function getTypeStringAttribute()
    {
        return BusinessSchedule::getTypeStringFromNumber($this->type);
    }

    public function getSectionOfDayStringAttribute()
    {
        return BusinessSchedule::getSectionOfDayStringFromNumber($this->section_of_day);
    }

    public function updateSubmissionEntry($submission_entry_id)
    {
        $this->submission_entry_id = $submission_entry_id;
        $this->save();
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
        if (\gettype($type) == 'string') {
            $type = BusinessSchedule::getTypeNumberFromString($type);
        }
        $this->type = $type;
        $this->save();
    }

    public function updateSectionOfDay($section_of_day)
    {
        if (\gettype($section_of_day) == 'string') {
            $section_of_day = BusinessSchedule::getSectionOfDayStringFromNumber($section_of_day);
        }
        $this->section_of_day = $section_of_day;
        $this->save();
    }

    public function updateByAppoitment($by_appointment)
    {
        $this->by_appointment = $by_appointment;
        $this->save();
    }

    public function updateByAppoitmentContacts($by_appointment_contacts)
    {
        $this->by_appointment_contacts = $by_appointment_contacts;
        $this->save();
    }
}
