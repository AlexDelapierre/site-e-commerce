<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        for($img = 1; $img <= 10; $img++){
            $image = new Images();
            $image->setName($faker->image(null, 640, 480));
            $product = $this->getReference('prod-'.rand(1, 10));
            $image->setProducts($product);
            $manager->persist($image); 
        }

        $manager->flush();
    }

    //Méthode de la DependentFixtureInterface qui permet de changer l'ordre alphabétique du chargement des fixtures lors d'un data load
    public function getDependencies(): array
    {
        return [
            ProductsFixtures::class
        ];
    }
}