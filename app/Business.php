<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Business extends Model
{
    protected $appends = ['image','sector_string'];

    private static $sector_strings = [
        'Minimercados, supermercados, hipermercados',
        'Frutarias, talhos, peixarias, padarias',
        'Mercados, para venda de produtos alimentares',
        'Produção e distribuição agroalimentar',
        'Lotas',
        'Restauração e bebidas, apenas para take-away',
        'Confeção de refeições prontas a levar para casa, apenas take-away',
        'Serviços médicos ou outros serviços de saúde e apoio social',
        'Farmácias e Parafarmácias',
        'Lojas de produtos médicos e ortopédicos',
        'Oculistas',
        'Lojas de produtos cosméticos e de higiene',
        'Lojas de produtos naturais e dietéticos',
        'Serviços públicos essenciais de água, energia elétrica, gás natural e gases de petróleo liquefeitos canalizados',
        'Serviços recolha e tratamento de águas residuais, recolha e tratamento de águas residuais e resíduos sólidos urbanos, higiene urbana e serviço de transporte de passageiros',
        'Serviços de comunicações eletrónicas e correios',
        'Papelarias, tabacarias e jogos sociais',
        'Clínicas veterinárias',
        'Lojas de venda de animais de companhia e respetivos alimentos',
        'Lojas de venda de flores, plantas, sementes e fertilizantes',
        'Lojas de lavagem e limpeza a seco de roupa',
        'Drogarias',
        'Lojas de bricolage e outros',
        'Postos de abastecimento de combustível',
        'Estabelecimentos de venda de combustíveis para uso doméstico;',
        'Oficinas e venda de peças mecânicas',
        'Lojas de venda e reparação de eletrodomésticos, equipamento informático e de comunicações e respetiva reparação',
        'Bancos, Seguros e Serviços Financeiros',
        'Funerárias',
        'Serviços de manutenção e reparações, em casa',
        'Serviços de segurança ou de vigilância, em casa',
        'Atividades de limpeza, desinfeção, desratização e similares',
        'Serviços de entrega ao domicílio',
        'Estabelecimentos turísticos, exceto parques de campismo, apenas com serviço de restaurante e bar para os respectivos hóspedes',
        'Serviços que garantam alojamento estudantil',
        'Atividades e estabelecimentos enunciados nos números anteriores, ainda que integrados em centros comerciais',
    ];

    public static function getSectorNumberFromString($sector)
    {
        $sector = \array_search($sector, Business::$sector_strings, true);
        if ($sector == -1) {
            $sector = 0;
        }
        return $sector;
    }

    public static function getSectorStringFromNumber($sector)
    {
        return Business::$sector_strings[$sector];
    }

    public static function createBusiness($company, $store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector, $firstname, $lastname, $contact, $email, $user_id = null)
    {
        if (\gettype($sector) == 'string') {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $business               = new Business();
        $business->company      = $company;
        $business->store_name   = $store_name;
        $business->address      = $address;
        $business->parish       = $parish;
        $business->county       = $county;
        $business->district     = $district;
        $business->postal_code  = $postal_code;
        $business->lat          = $lat;
        $business->long         = $long;
        $business->phone_number = $phone_number;
        $business->sector       = $sector;
        $business->firstname    = $firstname;
        $business->lastname     = $lastname;
        $business->contact      = $contact;
        $business->email        = $email;
        $business->user_id      = $user_id;
        $business->save();
        return $business;
    }

    public static function findBusinesses($lat, $long, $store_name)
    {
        return Business::whereBetween('lat', [$lat - 0.0001, $lat + 0.0001])->whereBetween('long', [$long - 0.0001, $long + 0.0001])->where('store_name', '=', $store_name)->get();
    }

    public function schedules()
    {
        return $this->hasMany(BusinessSchedule::class);
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute()
    {
        $allowed_extensions = ['.jpg','.jpeg','.png'];
        $image_name         = null;
        foreach ($allowed_extensions as $extension) {
            if (Storage::disk('public_businesses')->exists($this->id.$extension)) {
                $image_name = $this->id.$extension;
                break;
            }
        }
        return $image_name;
    }

    public function getSectorStringAttribute()
    {
        return Business::getSectorStringFromNumber($this->sector);
    }

    public function addSchedule($start_hour, $end_hour, $sunday, $monday, $tuesday, $wednesday, $thrusday, $friday, $saturday, $type, $section_of_day, $by_appoitment, $by_appoitment_contacts)
    {
        BusinessSchedule::createSchedule($this->id, $start_hour, $end_hour, $sunday, $monday, $tuesday, $wednesday, $thrusday, $friday, $saturday, $type, $section_of_day, $by_appoitment, $by_appoitment_contacts);
    }

    public function removeSchedules()
    {
        $this->schedules()->delete();
    }

    public function updateStoreInformation($company, $store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector)
    {
        if (\gettype($sector) == 'string') {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $this->company      = $company;
        $this->store_name   = $store_name;
        $this->address      = $address;
        $this->parish       = $parish;
        $this->county       = $county;
        $this->district     = $district;
        $this->postal_code  = $postal_code;
        $this->lat          = $lat;
        $this->long         = $long;
        $this->phone_number = $phone_number;
        $this->sector       = $sector;
        $this->save();
    }

    public function updateCompany($company)
    {
        $this->company = $company;
        $this->save();
    }

    public function updateStoreName($store_name)
    {
        $this->store_name = $store_name;
        $this->save();
    }

    public function updateAddress($address)
    {
        $this->address = $address;
        $this->save();
    }

    public function updateParish($parish)
    {
        $this->parish = $parish;
        $this->save();
    }

    public function updateCounty($county)
    {
        $this->county = $county;
        $this->save();
    }

    public function updateDistrict($district)
    {
        $this->district = $district;
        $this->save();
    }

    public function updatePostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        $this->save();
    }

    public function updateLatitute($lat)
    {
        $this->lat = $lat;
        $this->save();
    }

    public function updateLongitude($long)
    {
        $this->long = $long;
        $this->save();
    }

    public function updatePhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
        $this->save();
    }

    public function updateSector($sector)
    {
        if (\gettype($sector) == 'string') {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $this->sector = $sector;
        $this->save();
    }

    public function updateContactInformation($firstname, $lastname, $contact, $email)
    {
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
        $this->contact   = $contact;
        $this->email     = $email;
        $this->save();
    }

    public function updateFirstname($firstname)
    {
        $this->firstname = $firstname;
        $this->save();
    }

    public function updateLastname($lastname)
    {
        $this->lastname = $lastname;
        $this->save();
    }

    public function updateContact($contact)
    {
        $this->contact = $contact;
        $this->save();
    }

    public function updateEmail($email)
    {
        $this->email = $email;
        $this->save();
    }

    public function setOwner($user_id)
    {
        $this->user_id = $user_id;
        $this->save();
    }
}
