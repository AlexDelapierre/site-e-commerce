<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(OrdersRepository $ordersRepository): Response
    {
        // On récupère l'utilisateur connecté 
        $user = $this->getUser();
        
        // Utilisation du repository pour récupérer un tableau contenant les commandes de l'utilisateur connecté
        $orders = $ordersRepository->findBy(['users' => $user]);

        return $this->render('orders/index.html.twig', compact('orders'));
    }
    
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProductsRepository $productsRepository,
    EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        //Si le panier est vide
        if ($panier === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('main');
        }

        //Le panier n'est pas vide, on crée la commande
        $order = new Orders();

        //On remplit la commande
        $order->setUsers($this->getUser());
        $order->setReference(uniqid());
        
        //On parcourt le panier pour créer les détails de commande
        foreach ($panier as $item => $quantity) {
            $orderDetails = new OrdersDetails();

            //On va chercher le produit
            $product = $productsRepository->find($item);
            
            $totalPrice = $product->getPrice() * $quantity;

            //On crée le détail de commande
            $orderDetails->setProducts($product);
            $orderDetails->setTotalPrice($totalPrice);
            $orderDetails->setQuantity($quantity);
            
            $order->addOrdersDetail($orderDetails);
        }

        //On persiste et on flush
        $em->persist($order);
        $em->flush();

        $session->remove('panier');

        $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute('main');
    }
}