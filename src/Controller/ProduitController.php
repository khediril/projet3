<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit", name="produit_")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/add/{name}/{price}/{quantity}", name="add")
     */
    public function index($name, $price, $quantity): Response
    {
        $produit = new Produit();
        $produit->setName($name);
        $produit->setPrice($price);
        $produit->setQuantity($quantity);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);

        $entityManager->flush();

        return $this->render('produit/add.html.twig', [
            'produit' => $produit,
        ]);
    }
    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        

        return $this->render('produit/list.html.twig', [
            'produits' => $produits,
        ]);
    }
    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id): Response
    {
        
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$produit) {
          /*  throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );*/
            $this->addFlash(
                'notice',
                'Aucun produit avec ID : '.$id
            );
            return $this->redirectToRoute('produit_list');
        }
      
        
        return $this->render('produit/detail.html.twig', [
            'produit' => $produit,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id): Response
    {
        
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$produit) {
          /*  throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );*/
            $this->addFlash(
                'notice',
                'Aucun produit avec ID : '.$id . ' Vérifiez le id'
            );
            return $this->redirectToRoute('produit_list');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();
        
        $this->addFlash(
            'succes',
            'Le produit avec ID : '.$id .' est supprimé avec succés'
        );
        return $this->redirectToRoute('produit_list');
    }
    /**
     * @Route("/update/{id}/{newName}", name="update")
     */
    public function update($id,$newName): Response
    {
        
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$produit) {
          /*  throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );*/
            $this->addFlash(
                'notice',
                'Aucun produit avec ID : '.$id . ' Vérifiez le id'
            );
            return $this->redirectToRoute('produit_list');
        }
        $produit->setName($newName);
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();
        
        $this->addFlash(
            'succes',
            'Le produit avec ID : '.$id .' est modifié avec succés'
        );
        return $this->redirectToRoute('produit_list');
    }
    /**
     * @Route("/listparprix/{pmin}/{pmax}", name="listparprix")
     */
    public function listParPrix($pmin,$pmax): Response
    {
        
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findByPriceInterval2($pmin,$pmax);
        

        return $this->render('produit/listparprix.html.twig', [
            'produits' => $produits,'min'=> $pmin,'max'=> $pmax
        ]);
    }
    
}
