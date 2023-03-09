<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Products;
use App\Form\ProductsFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/produits', name: 'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, 
    PictureService $pictureService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //On crée un nouveau produit
        $product = new Products();

        //On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //On traite la requête du formulaire
        $productForm->handleRequest($request);

        //On vérifie si le formulaire est soumis Et valide
        if($productForm->isSubmitted() && $productForm->isValid()){
            //On récupère les images 
            $images = $productForm->get('image')->getData();
            
            foreach($images as $image){
                // On définit le dossier de déstination
                $folder = 'products';

                // On appel le service d'ajout
                $fichier = $pictureService->add($image, $folder, 300, 300);

                $img = new Images();
                $img->setName($fichier);
                $product->addImage($img);
            }

            // On génère le slug
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            // On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            // On stocke 
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');
        
            // On redirige
            return $this->redirectToRoute('admin_products_index');
        }

        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);   
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $em, 
    SluggerInterface $slugger): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le Voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        // On divise le prix par 100
        $prix = $product->getPrice() / 100;
        $product->setPrice($prix);
        
        //On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //On traite la requête du formulaire
        $productForm->handleRequest($request);

        //On vérifie si le formulaire est soumis Et valide
        if($productForm->isSubmitted() && $productForm->isValid()){
            // On génère le slug
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            // On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            // On stocke 
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès');
        
            // On redirige
            return $this->redirectToRoute('admin_products_index');
        }

        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        // On vérifie si l'utilisateur peut supprimer avec le Voter
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);
        
        return $this->render('admin/products/index.html.twig');
    }
}