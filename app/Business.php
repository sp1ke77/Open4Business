<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    public static function getSectorNumberFromString($sector)
    {
        $sector_strings = [
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
        $sector = \array_search($sector, $sector_strings, true);
        if ($sector == -1) {
            $sector = 0;
        }
        return $sector;
    }

    public static function createBusiness($store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector, $firstname, $lastname, $contact, $email)
    {
        if (\is_string($sector)) {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $business               = new Business();
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
        $business->save();
        return $business;
    }

    public function schedules()
    {
        return $this->hasMany(BusinessSchedule::class);
    }

    public function addSchedule($start_hour, $end_hour, $sunday, $monday, $tuesday, $wednesday, $thrusday, $friday, $saturday, $type)
    {
        BusinessSchedule::createBusiness($this->id, $start_hour, $end_hour, $sunday, $monday, $tuesday, $wednesday, $thrusday, $friday, $saturday, $type);
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
        if (\is_string($sector)) {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $this->sector = $sector;
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
}
