<?php

namespace App\Controller;

use App\Repository\EntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entryRepository;

    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    /**
     * @Route("/", name="home_index")
     */
    public function index(Request $request): Response
    {
        $parameters = [];

        if ($request->query->has('search')) {
            $searchPhrase = $request->query->get('search');
            $entries = $this->entryRepository->findByTitlePart($searchPhrase);

            $parameters = ['entries' => $entries];
        }

        return $this->render('home/index.html.twig', $parameters);
    }
}
