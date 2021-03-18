<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        $soapClient = new \SoapClient('http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?wsdl');
        $params = new \stdClass();
        $params->sCountryISOCode = 'MAR';
        $result = $soapClient->CapitalCity($params);
        dump($result);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
