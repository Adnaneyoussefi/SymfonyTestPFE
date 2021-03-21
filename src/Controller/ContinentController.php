<?php

namespace App\Controller;

use App\Entity\Countrie;
use App\Entity\Language;
use App\Entity\Continent;
use App\service\CountrieService;
use App\service\LanguageService;
use App\service\ContinentService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContinentController extends AbstractController
{
    /**
     * @Route("/continent", name="continent")
     */
    public function index(): Response
    {
        $continentService = new ContinentService();
        $continents = $continentService->getContinentsDataWithCountries();

        dump($continents);
        
        return $this->render('continent/index.html.twig', [
            'listContinent' => $continents,
        ]);
    }

    /**
     * @Route("/continent/{sCode}", name="countrieByContinent", methods={"GET","POST"})
     */
    public function afficher(PaginatorInterface $paginator, Request $request): Response {
        $continentService = new ContinentService();
        $continents = $continentService->getContinentsDataWithCountries();
        
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

        $languageService = new LanguageService();

        dump($languageService->getLanguagesData());
        return $this->render('continent/detail.html.twig', [
            'countries' => $page
        ]);
    }
}
