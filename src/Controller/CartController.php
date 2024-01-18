<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(SessionInterface $session, ProductsRepository $productsRepository)
  {
    $panier = $session->get('panier', []);

    //On initialise des variables
    $data = [];
    $total = 0;

    foreach ($panier as $id => $quantity) {
      $product = $productsRepository->find($id);

      $data[] = [
        'product' => $product,
        'quantity' => $quantity
      ];
      $total += $product->getPrice() * $quantity; 
    }

  }  

  #[Route('/add/{id}', name: 'add')]
  public function add(Products $product, SessionInterface $session)
  {
    //On récupère l'id du produit
    $id = $product->getId();

    //On récupère le panier existant
    $panier = $session->get('panier', []);

    //On ajoute le produit dans le panier s'il n'y est pas encore
    //Sinon on incrémente sa quantité
    if(empty($panier[$id])){
      $panier[$id] = 1;
    }else{
      $panier[$id]++;
    }

    $session->set('panier', $panier);
    
    //On redirige vers la page du panier
    return $this->redirectToRoute('cart_index');
  }
  
}