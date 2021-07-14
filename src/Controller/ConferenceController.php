<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
/* We don’t even need to extend the AbstractController class if we want to be explicit about our dependencies. */
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    private $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $this;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return new Response($this->twig->render('conference/index.html.twig', ['conferences' => $conferenceRepository->findAll()]));
    }



    /* To manage the pagination in the template,
    * Pass the Doctrine Paginator instead of the Doctrine Collection to Twig: */

    /**
     * @Route("/conference/{slug}", name="conference")
     */
    public function show(Request $request, Conference $conference, CommentRepository $commentRepository): Response
    {

        /* gets the offset from the Request query string ($request->query) as an integer (getInt()), defaulting to 0 if not available. */
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        return new Response($this->twig->render(
            'conference/show.html.twig',
            [
                'conference' => $conference,
                'comments' => $paginator,
                /* The previous and next offsets are computed based on all the information we have from the paginator */
                'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE)
            ]
        ));
    }
}
