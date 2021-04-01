<?php

namespace App\Controller;

use GuzzleHttp\Client;
use App\Data\SearchData;
use App\Service\AllData;
use App\Form\SearchFormType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController
{
    /**
     * @Route("/countries", name="countries")
     */
    public function index(PaginatorInterface $paginator, Request $request, CacheInterface $cache,
    AllData $a, AllData $w): Response
    {
        $countries = $cache->get('countries', function() use($a) {
            return $a->getAllData()["country"];
        });

        $data = new SearchData();
        $form = $this->createForm(SearchFormType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $countries = array_filter($countries, function($x) use($form) {
                if(!empty($form->getNormData()->recherche) && !empty($form->getNormData()->continents))
                    return (strpos(strtolower($x->getsName()), strtolower($form->getNormData()->recherche)) === 0
                && in_array($x->getContinent()->getsCode(), $form->getNormData()->continents));
                elseif(!empty($form->getNormData()->recherche)) {
                    return (strpos(strtolower($x->getsName()), strtolower($form->getNormData()->recherche)) === 0);
                }
                elseif(!empty($form->getNormData()->continents)) {
                    return (in_array($x->getContinent()->getsCode(), $form->getNormData()->continents));
                }
            });
        }

        $page = $paginator->paginate(
            $countries,
            $request->query->getInt('page', 1),
            12
        );

        dump($request->attributes->get('_route_params'));
        return $this->render('country/index.html.twig', [
            'controller_name' => 'CountrieController',
            'listCountrie' => $page,
            'form' => $form->createView(),
        ]);

        /*$msc = microtime(true);
        $soapClient->FullCountryInfoAllCountries()
        ->FullCountryInfoAllCountriesResult
        ->tCountryInfo;
        $msc = microtime(true)-$msc;
        var_dump($msc);*/
    }

    /**
     * @Route("/countries/weather/{name}", name="weather")
     */
    public function weather(string $name, AllData $w)
    {
        return $this->json($w->getData($name));
    }
}
