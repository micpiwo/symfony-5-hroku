<?php

namespace App\Controller;

use App\Entity\Distributeur;
use App\Entity\Produits;
use App\Entity\Recherche;
use App\Form\ProduitsType;
use App\Form\RechercheType;
use App\Repository\ProduitsRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitsController
 * @package App\Controller
 */

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     * @param Request $request
     * @param ProduitsRepository $produitsRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, ProduitsRepository $produitsRepository,PaginatorInterface $paginator): Response
    {


        $produits = new Produits();
        $searchForm = $this->createForm(RechercheType::class,$produits);

        $searchForm->handleRequest($request);
        $prix = $produits->getPrixProduit();
        $cat = $produits->getCategorieId();

        //dd($query);
        $pagination = $paginator->paginate(
            $annonce = $produitsRepository->searchParameters($prix, $cat),
            //Passage d'un paramètre dans url ?page=1 par defaut puis 3 par page
            $request->query->getInt('page', 1),100
        );


        //dd($prix);



        return $this->render('produits/index.html.twig', [
            'controller_name' => 'ProduitsController',
            'pagination' => $pagination,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route ("/produits/{slug}/{id}", name="details_produit")
     * @param Produits $produits
     * @return Response
     */
    public function detailProduits(Produits  $produits){
        return $this->render('produits/details.html.twig',[
            'produit' => $produits
        ]);
    }


    /**
     * @Route ("/produits/ajouter", name="ajouter_produit")
     * @param Request $request
     * @return Response
     */
    public function ajouterProduit(Request $request):Response{
        $produits = new Produits();
        $formProduit = $this->createForm(ProduitsType::class, $produits);
        $formProduit->add("ajouter", SubmitType::class, array(
            'label' => 'Ajouter le produit'
        ));
        $formProduit->handleRequest($request);
        if($request->isMethod('post') && $formProduit->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $file = $formProduit['imageProduit']->getData();
            if(!is_string($file)){
                $filename = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
                $produits->setImageProduit($filename);
            }else{
                $session = $request->getSession();
                $session->getFlashBag()->add('message', 'Merci de choisir une image valide');
                $session->set('statut', 'danger');

                return  $this->redirect($this->generateUrl('ajouter_produit'));
            }
            $entityManager->persist($produits);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('produits'));
        }
        return $this->render('produits/ajouter.html.twig',[
            'formProduit' => $formProduit->createView(),
            'validation_groups' => array('all')
        ]);

    }

    /**
     * @Route ("/produits/editer/{slug}/{id}", name="editer_produit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editerProduit(Request $request, $id):Response{
        $entityManager = $this->getDoctrine()->getManager();
        $produitRepository = $entityManager->getRepository(Produits::class);
        $produit = $produitRepository->find($id);

        $img = $produit->getImageProduit();

        $edit_formProduit = $this->createForm(ProduitsType::class, $produit);

        $edit_formProduit->add('editer', SubmitType::class,[
            'label' => 'Mettre à jour'
        ]);
        $edit_formProduit->handleRequest($request);

        if($request->isMethod('post') && $edit_formProduit->isValid()){
            $file = $edit_formProduit['imageProduit']->getData();
            if(!is_string($file)){
                $filename = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
                $produit->setImageProduit($img);
            }else{
                $produit->setImageProduit($img);
            }
            $entityManager->persist($produit);
            $entityManager->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'Le produit à bien été mis a jour !');
            $session->set('statut', 'success');
            return $this->redirect($this->generateUrl('produits'));
        }
    return $this->render('produits/editer.html.twig',[
        'edit_form' => $edit_formProduit->createView(),
        'validation_groups' => array('all')
    ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer_produit")
     */

    public function supprimerProduit(Request $request, $id):Response{
        $entityManager = $this->getDoctrine()->getManager();
        $produitRepository = $entityManager->getRepository(Produits::class);
        $produit = $produitRepository->find($id);

        $entityManager->remove($produit);

        $entityManager->flush();
        $session = $request->getSession();
        $session->getFlashBag()->add('message', 'Le produit à bien été supprimer !');
        $session->set('statut', 'success');
        return $this->redirect($this->generateUrl('produits'));
    }

    /**
     * @Route ("/produits/distributeurs", name="liste_distributeurs")
     */
    public function listeDistributeurs():Response{
        $entityManager = $this->getDoctrine()->getManager();
        $distributeurRepository = $entityManager->getRepository(Distributeur::class);

        $distributeur = $distributeurRepository->findAll();

        return $this->render('produits/distributeurs.html.twig',[
            'distributeurs' => $distributeur
        ]);
    }
}
