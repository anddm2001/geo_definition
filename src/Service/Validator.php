<?php

namespace App\Service;

class Validator{

    private $error = [
        1 => "Минимальная длина номера- 10 цифр!",
        2 => "Максимальная длина номера- 16 цифр!",
        3 => "Номер не может быть пустым!",
        4 => "Внешний API вернул пустое значение!",
        5 => "Передан пустым обязательный параметр!"
    ];
    private $MAX_LENGTH = 16;
    private $MIN_LENGTH = 10;

    public function validate($tel){

        if(!empty($tel)){
            if(strlen($tel) < $this->MIN_LENGTH){
                return $this->error[1];
            }elseif(strlen($tel) > $this->MAX_LENGTH){
                return $this->error[2];
            }else{
                return $tel;
            }
        }
        return $this->error[3];
    }

    public function formatPhone($tel){

        $result = [];
//        $tel = str_replace("+", "", $tel);
        if(!empty($tel) && strlen($tel) >= 10){
            $phone = substr($tel, -10);
            $prefix = str_replace($phone, "", $tel);
            $result["phone"] = $phone;
            $result["prefix"] = $prefix;
            return $result;
        }
        return $this->error[3];
    }
}
