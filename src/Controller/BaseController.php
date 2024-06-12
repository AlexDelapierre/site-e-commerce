<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CategoriesService;

abstract class BaseController extends AbstractController
{
    protected $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    protected function getCategories(): array
    {
        return $this->categoriesService->getCategories();
    }
}