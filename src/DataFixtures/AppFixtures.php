<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
       $this->passwordEncoder = $passwordEncoder;
        
    }
    public function load(ObjectManager $manager)
    {
        // création des catégories
        $cat1 = new Categorie();
        $cat1->setName('categorie1');
        $manager->persist($cat1);
        $cat2 = new Categorie();
        $cat2->setName('categorie2');
        $manager->persist($cat2);
       
        // Création des fournisseurs
        $f1 = new Fournisseur();
        $f1->setName('fournissuer1');
        $f1->setAdresse('Adresse1');
        $f1->setEmail('fournisseur1@gmail.com');
        $f1->setTel('71200200');
        $manager->persist($f1);
        $f2 = new Fournisseur();
        $f2->setName('fournissuer2');
        $f2->setAdresse('Adresse2');
        $f2->setEmail('fournisseur2@gmail.com');
        $f2->setTel('71100100');
        $manager->persist($f2);

        $f3 = new Fournisseur();
        $f3->setName('fournissuer3');
        $f3->setAdresse('Adresse3');
        $f3->setEmail('fournisseur3@gmail.com');
        $f3->setTel('71300300');
        $manager->persist($f3);

        // création des produits
        for ($i = 1; $i < 30; $i++) {
            $produit = new Produit();
            $produit->setName('produit' . $i);
            $produit->setPrice(rand(100, 5000));
            $produit->setQuantity(rand(10, 100));
            $produit->setPhoto('sucre.jpg');

            if ($i % 2 == 0) {
                $produit->setCategorie($cat1);
            } else {
                $produit->setCategorie($cat2);
            }

            if ($i % 3 == 0) {
                $produit->addFournisseur($f1);
            } elseif ($i % 3 == 1) {
                $produit->addFournisseur($f2);
            } else {
                $produit->addFournisseur($f3);
            }
            $manager->persist($produit);
        }
        
        $user = new User();
        $user->setNom("Ben Salah");
        $user->setPrenom("Ali");
        $user->setEmail("ali@gmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         'admin'
                    )) ;
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);      
        $user = new User();
        $user->setNom("karkar");
        $user->setPrenom("yassine");
        $user->setEmail("yassine@gmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         'yassine'
                    )) ;
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
