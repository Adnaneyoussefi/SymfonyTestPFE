<?php

namespace App\Controller;

use App\service\AllData;
use App\service\CountryAPI;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContinentController extends AbstractController
{
    /**
     * @Route("/continents", name="continents")
     */
    public function index(CacheInterface $cache): Response
    {
        $allData = new AllData();
        $countryApi = new CountryAPI();
        $allData->setService($countryApi);
        //$continents = $allData->getAllData()["continent"];

        $continents = $cache->get('continents', function() use($allData) {
            return $allData->getAllData()["continent"];
        });
        
        return $this->render('continent/index.html.twig', [
            'listContinent' => $continents,
        ]);
    }

    /**
     * @Route("/continents/{sCode}", name="countryByContinent", methods={"GET","POST"})
     */
    public function afficher(PaginatorInterface $paginator, Request $request, CacheInterface $cache): Response {

        $allData = new AllData();
        $countryApi = new CountryAPI();
        $allData->setService($countryApi);
        //$continents = $allData->getAllData()["continent"];
        
        $continents = $cache->get('continents', function() use($allData) {
            return $allData->getAllData()["continent"];
        });
        
        $routeParameters = $request->attributes->get('_route_params');
        $continent = array_filter($continents, function($x) use($routeParameters) {
            return ($x->getsCode() == $routeParameters["sCode"]);
        });

        $continent = $continent[array_keys($continent)[0]];

        $page = $paginator->paginate(
            $continent->getCountries(),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('continent/detail.html.twig', [
            'countries' => $page
        ]);
    }
}
