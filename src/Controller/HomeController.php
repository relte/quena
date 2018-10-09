<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * @Route("/", name="home_index")
     */
    public function index(Request $request): Response
    {
        $parameters = [];

        if ($request->query->has('search')) {
            $searchPhrase = $request->query->get('search');
            $answers = $this->answerRepository->findByPhrase($searchPhrase);

            $parameters = ['answers' => $answers];
        }

        return $this->render('home/index.html.twig', $parameters);
    }
}
