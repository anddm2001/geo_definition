<?php

namespace App\Service;

use App\Repository\SearchIndexRepository;
use App\Entity\SearchIndex;

class CacheManager{

    private $em;
    private $error = [
        5 => "Передан пустым обязательный параметр!"
    ];

    public function __construct(SearchIndexRepository $SearchIndexRepository)
    {
        $this->em = $SearchIndexRepository;
    }

    public function getSearchIndex($tel){

        $result = [];

        if($tel){
            $tel = intval($tel);
            $data = $this->em->findByTelField($tel);
            if($data){
                $result["country"] = $data->getCountry();
                $result["region"] = $data->getRegion();
                $result["timezone"] = $data->getTimezone();
                return $result;
            }
            return $data;
        }
        return $this->error[5];
    }
}
