<?php

namespace App\Twig;

use App\Service\CategoriesService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * Cette extension Twig rend les catégories disponibles dans tous les templates Twig.
 */
class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private $categoriesService;

    /**
     * $categoriesService Le service de catégories
     */
    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    /**
     * Définit les variables globales pour Twig.
     *
     * @return array Un tableau de variables globales
     */
    public function getGlobals(): array
    {
        return [
            'categories' => $this->categoriesService->getCategories(),
        ];
    }
}