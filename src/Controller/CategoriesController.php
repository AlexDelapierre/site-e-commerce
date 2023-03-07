<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function details(Categories $category): Response
    {
        //On va chercher la liste des produits de la catégorie
        $products = $category->getProducts();

        //La fonction compact() va chercher $product et en fait un tableau associatif
        return $this->render('categories/list.html.twig', compact('category',
    'products'));

        //Autre syntaxe possible sans le compact()
        // return $this->render('categories/list.html.twig', [
        //     'category' => $category,
        //     'products' => $products
        // ]);
    }
}