<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(Mailer $mailer,Sevice2 $s2): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'GLDRA1',
        ]);
    }
    /**
     * @Route("/test1", name="test1")
     */
    public function test1(): Response
    {
        $tab = ["ali", "salah", "nesrine", "khaoula", "kamel"];


        // dd($tab);

        return $this->render('test/test1.html.twig', [
            'noms' => $tab

        ]);
    }
    /**
     * @Route("/test3", name="test3")
     */
    public function test3(Request $request): Response
    {
        $reponse = new Response('<html><head></head><body>Page test 3</body></html>');

        return $reponse;
    }
    /**
     * @Route("/test4/{nom}", name="test4")
     */
    public function test4($nom): Response
    {
        return $this->render('test/test4.html.twig', [
            'nom' => $nom

        ]);
    }
}
