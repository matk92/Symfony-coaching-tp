<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Repository\CoachRepository;
use App\Repository\ProgramRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(Request $request, CoachRepository $coachRepository, ProgramRepository $programRepository, SessionRepository $sessionRepository): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned_page');
        }

        $search = $request->query->get('search');
        $filter = $request->query->get('filter');

        $results = [];

        if ($filter === 'coach' || $filter === '') {
            $results['coachs'] = $coachRepository->findBySearchAndFilter($search, $filter);
        }

        if ($filter === 'program' || $filter === '') {
            $results['programs'] = $programRepository->findBySearchAndFilter($search, $filter);
        }

        if ($filter === 'session' || $filter === '') {
            $results['sessions'] = $sessionRepository->findBySearchAndFilter($search, $filter);
        }

        return $this->render('home/index.html.twig', [
            'results' => $results,
            'current_route' => 'home',
        ]);
    }

    #[Route('/banned', name: 'banned_page')]
    public function banned(): Response
    {
        return $this->render('error/banned.html.twig');
    }
}