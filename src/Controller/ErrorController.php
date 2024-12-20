<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'error')]
    public function show(Request $request): Response
    {
        $exception = $request->attributes->get('exception');
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($statusCode === Response::HTTP_NOT_FOUND) {
            return $this->render('error/404.html.twig');
        }

        return $this->render('error/error.html.twig', [
            'status_code' => $statusCode,
            'message' => $exception->getMessage(),
        ]);
    }
}