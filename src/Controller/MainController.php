<?php

namespace App\Controller;

use App\Entity\SearchIndex;
use App\Service\ApiClient;
use App\Service\Validator;
use App\Service\CacheManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    private $ApiClient;
    private $Validator;
    private $CacheManager;
    private $error = [
        1 => "Минимальная длина номера- 10 цифр!",
        2 => "Максимальная длина номера- 16 цифр!",
        3 => "Номер не может быть пустым!",
        4 => "Внешний API вернул пустое значение!",
        5 => "Передан пустым обязательный параметр!"
    ];
    private $MAX_LENGTH = 16;

    public function __construct(ApiClient $ApiClient, Validator $Validator, CacheManager $CacheManager){
        $this->ApiClient = $ApiClient;
        $this->Validator = $Validator;
        $this->CacheManager = $CacheManager;
    }

    /**
     * @Route("/", name="main")
     * @Method({"POST","GET"})
     */
    public function index(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $res = $this->Validator->validate($request->request->get('tel'));
            if(strlen($res) <= $this->MAX_LENGTH){
                $res_arr = $this->Validator->formatPhone((string)$res);
                if(!empty($res_arr)){
                    $check_cache = $this->CacheManager->getSearchIndex($res_arr["phone"]);
                    if(!empty($check_cache)){
                        //Нашли в кэше.
                        return new JsonResponse($check_cache);
                    }else{
                        //Не нашли номер в кэше.
                        $result = $this->ApiClient->newAPI($res);
                        $company = "";
                        if(count($result) > 0){
                            $this->setSearchIndex($res, $result["country"], $result["region"], $company, $result["timezone"]);
                            return new JsonResponse($result);
                        }else{
                            return new JsonResponse($this->error[4]);
                        }
                    }
                }
            }
            return new JsonResponse($res);
        }else{
            return $this->render('index.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
    }

    protected function setSearchIndex($tel, $country, $region = "", $company = "", $timezone = ""){

        $manager = $this->getDoctrine()->getManager();
        $cache_row = new SearchIndex();
        $cache_row->setCountry($country);
        $cache_row->setRegion($region);
        $cache_row->setTimezone($timezone);
        $cache_row->setCompany($company);
        $cache_row->setTel($tel);
        $manager->persist($cache_row);
        $manager->flush();
    }
}
