<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
/**
 * @Route("/test2", name="test2_")
 */
class Test2Controller extends AbstractController
{
    /**
     * @Route("/testapi", name="testapi")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $tab=["aaaaa","bbbbb","ccccc"];
      //  $rep = $serializer.serialize($tab);
       /* return $this->render('test2/index.html.twig', [
            'controller_name' => 'Test2Controller',
        ]);*/
        return $this->json($tab);
    }
}
