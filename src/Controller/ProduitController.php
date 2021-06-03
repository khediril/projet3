<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Service\MessageGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/produit", name="produit_")
 * 
 */
class ProduitController extends AbstractController
{
    private $messageGenerator;
    public function __construct(MessageGenerator $messageGenerator)
    {
        $this->messageGenerator = $messageGenerator;
    }
  
    /**
     * @Route("/add/{name}/{price}/{quantity}", name="add")
     * 
     */
    public function add($name, $price, $quantity): Response
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
     * @Route("/ajout1", name="ajout1")
     */
    public function ajout1(): Response
    {
        $produit = new Produit();
        // Création du formulaire directement dans le controlleur
        $form = $this->createFormBuilder($produit)
            ->add('name', TextType::class)
            ->add('price', DateType::class)
            ->add('quantity', DateType::class)

            ->add('save', SubmitType::class, ['label' => 'Créer un produit'])
            ->getForm();


        /* $produit->setName($name);
        $produit->setPrice($price);
        $produit->setQuantity($quantity);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);

        $entityManager->flush();*/

        return $this->render('produit/add.html.twig', [
            'produit' => $produit,
        ]);
    }
    /**
     * @Route("/ajout2", name="ajout2")
     * 
     */
    public function ajout2(Request $request): Response
    {
        $produit = new Produit();
        // Création du formulaire à l'aide d'une classe externe
        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $produit = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);

            $entityManager->flush();
            
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('produit_list');
        }




        /* $produit->setName($name);
        $produit->setPrice($price);
        $produit->setQuantity($quantity);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);

        $entityManager->flush();*/

        return $this->render('produit/ajout2.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        $msg = $this->messageGenerator->getHappyMessage();
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $user = $this->getUser();
       // dd($user);

        return $this->render('produit/list.html.twig', [
            'produits' => $produits,'nom' => $user->getNom(),"message" => $msg
        ]);
    }
    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id): Response
    {

        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$produit) {
            /*  throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );*/
            $this->addFlash(
                'notice',
                'Aucun produit avec ID : ' . $id
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

        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$produit) {
            /*  throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );*/
            $this->addFlash(
                'notice',
                'Aucun produit avec ID : ' . $id . ' Vérifiez le id'
            );
            return $this->redirectToRoute('produit_list');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();

        $this->addFlash(
            'succes',
            'Le produit avec ID : ' . $id . ' est supprimé avec succés'
        );
        return $this->redirectToRoute('produit_list');
    }
    /**
     * @Route("/update/{id}/{newName}", name="update")
     */
    public function update($id, $newName): Response
    {

        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        if (!$produit) {
            /*  throw $this->createNotFoundException(
                'Aucun produit avec id '.$id
            );*/
            $this->addFlash(
                'notice',
                'Aucun produit avec ID : ' . $id . ' Vérifiez le id'
            );
            return $this->redirectToRoute('produit_list');
        }
        $produit->setName($newName);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();

        $this->addFlash(
            'succes',
            'Le produit avec ID : ' . $id . ' est modifié avec succés'
        );
        return $this->redirectToRoute('produit_list');
    }
    /**
     * @Route("/listparprix/{pmin}/{pmax}", name="listparprix")
     */
    public function listParPrix($pmin, $pmax): Response
    {

        $produits = $this->getDoctrine()->getRepository(Produit::class)->findByPriceInterval2($pmin, $pmax);


        return $this->render('produit/listparprix.html.twig', [
            'produits' => $produits, 'min' => $pmin, 'max' => $pmax
        ]);
    }
}
