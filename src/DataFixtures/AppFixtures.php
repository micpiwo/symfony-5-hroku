<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();
        $produit = Array();
        for ($i = 0; $i < 100; $i++) {
            $produit[$i] = new Produits();
            $produit[$i]->setNomProduit($faker->word);
            $produit[$i]->setDescriptionProduit($faker->word);

            $manager->persist($produit[$i]);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
