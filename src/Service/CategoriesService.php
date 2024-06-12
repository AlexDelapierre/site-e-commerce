<?php 

namespace App\Service;

use App\Repository\CategoriesRepository;

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