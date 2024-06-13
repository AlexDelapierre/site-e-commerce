<?php 

namespace App\Service;

use App\Repository\CategoriesRepository;

/**
 * Ce service fournit une méthode pour récupérer les catégories ordonnées.
 */
class CategoriesService
{
    private $categoriesRepository;
  
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;   
    }

    public function getCategories(): array
    {
        return $this->categoriesRepository->findBy([], ['categoryOrder' => 'asc']);
    }
  
}