<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        $soapClient = new \SoapClient('http://www.dneonline.com/calculator.asmx?wsdl');
        $params = new \stdClass();
        $params->intA = 4;
        $params->intB = 3;
        $result = $soapClient->Multiply($params);
        dump($result);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
