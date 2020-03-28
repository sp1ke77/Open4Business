<?php
declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessCSVSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $firstname;

    private $lastname;

    private $contact;

    private $email;

    private $csv_filepath;

    private $img_filepath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname, $lastname, $contact, $email, $csv_filepath, $img_filepath)
    {
        $this->firstname    = $firstname;
        $this->lastname     = $lastname;
        $this->contact      = $contact;
        $this->email        = $email;
        $this->csv_filepath = $csv_filepath;
        $this->img_filepath = $img_filepath;
    }

    private function removeAccents($string)
    {
        $table = [
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
        ];

        return \strtr($string, $table);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $csv_file = Storage::disk('local_csvfiles')->get($this->csv_filepath);
        $entries  = [];
        $data     = \str_getcsv($csv_file, "\n");
        foreach ($data as &$row) {
            $row = \str_getcsv($row);
            if (\mb_strpos(\mb_strtolower($row[0]), 'our') !== false) {
                continue;
            }
            $num_of_schedules     = (\count($row) - 12) / 3;
            $current_schedule_num = 12;
            $schedules            = [];
            for ($i = 0; $i < $num_of_schedules; $i++) {
                if ($row[$current_schedule_num] == '' || $row[$current_schedule_num + 1] == '' || $row[$current_schedule_num + 2] == '') {
                    continue;
                }
                $hours       = $row[$current_schedule_num];
                $hours       = \explode('-', $hours);
                $weekdays    = $row[$current_schedule_num + 1];
                $weekdays    = $this->removeAccents($weekdays);
                $weekdays    = \mb_strtolower($weekdays);
                $type        = $row[$current_schedule_num + 2];
                $schedules[] = [
                    'start_hour' => $hours[0],
                    'end_hour'   => $hours[1],
                    'type'       => $type,
                    'sunday'     => \mb_strpos($weekdays, 'domingo') !== false,
                    'monday'     => \mb_strpos($weekdays, 'segunda') !== false,
                    'tuesday'    => \mb_strpos($weekdays, 'terca') !== false,
                    'wednesday'  => \mb_strpos($weekdays, 'quarta') !== false,
                    'thrusday'   => \mb_strpos($weekdays, 'quinta') !== false,
                    'friday'     => \mb_strpos($weekdays, 'sexta') !== false,
                    'saturday'   => \mb_strpos($weekdays, 'sabado') !== false,
                ];
                $current_schedule_num = $current_schedule_num + 3;
            }

            $entries[] = [
                'business_id'  => ($row[0] == '' ? null: $row[0]),
                'company'      => $row[1],
                'store_name'   => $row[2],
                'address'      => $row[3],
                'parish'       => $row[4],
                'county'       => $row[5],
                'district'     => $row[6],
                'postal_code'  => $row[7],
                'lat'          => $row[8],
                'long'         => $row[9],
                'phone_number' => $row[10],
                'sector'       => $row[11],
                'schedules'    => $schedules,
            ];
        }
        ProcessMassSubmission::dispatch($this->firstname, $this->lastname, $this->contact, $this->email, $entries, $this->img_filepath);
        Storage::disk('local_csvfiles')->delete($this->csv_filepath);
    }
}