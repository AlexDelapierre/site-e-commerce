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

        // foreach ($orders as $key => $order) {
        //     dd($order->getOrdersDetails());
        // };
        
        // On récupère un tableau contenant le détail des commandes
        $ordersDetails = [];
        foreach ($orders as $order) {
            $ordersDetails[] = $order->getOrdersDetails();
        }
         
        /*
        // Itérer sur les détails de la commande pour accéder à leurs propriétés
        foreach ($ordersDetails as $detail) {
            // Exemple d'accès à une propriété (supposons que chaque détail a une méthode getName())
            $detailName = $detail->getName();
            
            // Ajouter les détails à un tableau pour l'affichage ou le traitement ultérieur
            $ordersDetails[] = [
                'name' => $detailName,
                // Autres propriétés à ajouter si nécessaire
            ];
        }
        */
    
        // Vérifie si il y a des commandes
        if (!$orders) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        return $this->render('orders/index.html.twig', compact('orders', 'ordersDetails'));
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
            
            $price = $product->getPrice();

            //On crée le détail de commande
            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
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