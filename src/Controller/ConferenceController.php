<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
/* We don’t even need to extend the AbstractController class if we want to be explicit about our dependencies. */
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        return new Response($twig->render('conference/index.html.twig', ['conferences' => $conferenceRepository->findAll()]));
    }
}
