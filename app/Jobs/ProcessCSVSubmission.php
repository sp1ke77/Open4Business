<?php
declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCSVSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $firstname;

    private $lastname;

    private $contact;

    private $email;

    private $csv_file;

    private $img_file;

    private $img_file_extension;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname, $lastname, $contact, $email, $csv_file, $img_file, $img_file_extension)
    {
        $this->firstname          = $firstname;
        $this->lastname           = $lastname;
        $this->contact            = $contact;
        $this->email              = $email;
        $this->csv_file           = $csv_file;
        $this->img_file           = $img_file;
        $this->img_file_extension = $img_file_extension;
    }

    private function removeAccents ($string) {
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        );
       
        return strtr($string, $table);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $entries = [];
        $data    = \str_getcsv($this->csv_file, "\n");
        foreach ($data as &$row) {
            $row       = \str_getcsv($row);
            if(strpos(strtolower($row[0]), 'our') !== false) {
                continue;
            }
            $num_of_schedules = (count($row)-12)/3;
            $current_schedule_num = 12;
            $schedules = [];
            for ($i=0; $i < $num_of_schedules; $i++) { 
                if($row[$current_schedule_num] == "" || $row[$current_schedule_num+1] == "" || $row[$current_schedule_num+2] == "") {
                    continue;
                }
                $hours = $row[$current_schedule_num];
                $hours = explode("-",$hours);
                $weekdays = $row[$current_schedule_num + 1];
                $weekdays = $this->removeAccents($weekdays);
                $weekdays = strtolower($weekdays);
                $type = $row[$current_schedule_num + 2];
                $schedules[] = [
                    'start_hour' => $hours[0],
                    'end_hour'   => $hours[1],
                    'type'       => $type,
                    'sunday'     => strpos($weekdays, 'domingo') !== false,
                    'monday'     => strpos($weekdays, 'segunda') !== false,
                    'tuesday'    => strpos($weekdays, 'terca') !== false,
                    'wednesday'  => strpos($weekdays, 'quarta') !== false,
                    'thrusday'   => strpos($weekdays, 'quinta') !== false,
                    'friday'     => strpos($weekdays, 'sexta') !== false,
                    'saturday'   => strpos($weekdays, 'sabado') !== false,
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
                'schedules'    => $schedules
            ];
        }
        ProcessMassSubmission::dispatch($this->firstname, $this->lastname, $this->contact, $this->email, $entries, $this->img_file, $this->img_file_extension);
    }
}
