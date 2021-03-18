<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Countrie;
use App\Entity\Language;
use App\Entity\Continent;
use App\Form\SearchFormType;
use App\service\CountrieService;
use App\service\ContinentService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountrieController extends AbstractController
{
    /**
     * @Route("/countrie", name="countrie")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $countrieService = new CountrieService();
        $countries = $countrieService->getCountryData();
        $languages = [];
        $tab = [];
        
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
                elseif(!empty($form->getNormData()->recherche)) {
                    return (in_array($x->getContinent()->getsCode(), $form->getNormData()->continents));
                }

                //return (in_array($x->getContinent()->getsCode(), $form->getNormData()->continents));
            });
        }

        $page = $paginator->paginate(
            $countries,
            $request->query->getInt('page', 1),
            12
        );

        $b = array_map(function ($v) {
            return $v->getsName();
        }, $countries);

        //$params = new \stdClass();

        dump($form);
        return $this->render('countrie/index.html.twig', [
            'controller_name' => 'CountrieController',
            'listCountrie' => $page,
            'form' => $form->createView()
        ]);
        
        /*$a = array_filter($result, function($x) {
            return (!isset($x->Languages->tLanguage));
        });
        
        $b = array_map(function ($v) {
            return $v->Languages;
        }, $result);
        */
    }
}
