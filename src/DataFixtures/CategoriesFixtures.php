<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;
    
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique', null, $manager, 0);
        
        $this->createCategory('Ordinateurs potables', $parent, $manager, 1);
        $this->createCategory('Ecrans', $parent, $manager, 2);
        $this->createCategory('Souris', $parent, $manager, 3);

        $parent = $this->createCategory('Mode', null, $manager, 4);
        
        $this->createCategory('Homme', $parent, $manager, 5);
        $this->createCategory('Femme', $parent, $manager, 6);
        $this->createCategory('Enfant', $parent, $manager, 7);
        
        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager, int $categoryOrder)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setcategoryOrder($categoryOrder);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        #Référence : mis en mémoire sous un nom d'un élément
        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++; 
        
        return $category;
    }
}