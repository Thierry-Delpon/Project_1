<?php


namespace App\Controller;


use App\Entity\Wish;
use App\Form\FormType;
use App\Repository\WishRepository;
use App\Services\Censurator;
use App\Services\TextUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route (path="wish/", name="wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route (path="test", name="test", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     */
    public function test(EntityManagerInterface $entityManager){
        $wish = new Wish();
        $wish->setTitle("Titre");
        $wish->setDescription("Description");
        $wish->setAuthor("Auteur");
        $wish->setDateCreated(new \DateTime('now'));
        $wish->setIsPublished(true);

        dump($wish);

        $entityManager->persist($wish);
        $entityManager->flush();

        dump($wish);
        exit();
    }
    /**
     * @Route (path="list", name="list", methods={"GET"})
     */
    public function list(WishRepository $wishRepository){

        $wishes = $wishRepository->findWithCategories();

        return $this->render('Wish/list.html.twig', ['wishes'=>$wishes]);

    }
     /**
      * @Route (path="{id}",requirements={"id": "\d+"}, name="detail", methods={"GET"})
      */
     public function detail(Request $request, EntityManagerInterface $entityManager){
         $id = $request->get('id');


         // Récupération de l'entité dans la BDD
         $wish = $entityManager->getRepository('App:Wish')->find($id);

         if (is_null($wish)) {
             throw $this->createNotFoundException();

         }
         return $this->render('Wish/detail.html.twig', ['wish' => $wish]);
     }


    /**
     * @Route (path="create", name="create", methods={"GET","POST"})
     */
     public function create(Request $request, EntityManagerInterface $entityManager, TextUtils $textUtils, Censurator $censurator) :Response{

         //commencer avec une entité vide
         $wish = new Wish();
         $wish->setAuthor($this->getUser()->getUsername());

         // on fait notre formulaire lié à notre entité vide
         $wishForm = $this->createForm(FormType::class, $wish);

         // je récupère les données et je l'insère dans mon $wish
         $wishForm->handleRequest($request);

         // si le formulaire est soumis et valide
         if ($wishForm->isSubmitted() && $wishForm->isValid()) {
             $purifiedDescription = $censurator->purify($wish->getDescription());
             $wish->setDescription($purifiedDescription);
             $wish->setDescription($textUtils->returnLineAfterDot($wish->getDescription()));
             $wish->setIsPublished(true);
             $wish->setDateCreated(new \DateTime());

             //sauvergarde en bdd
             $entityManager->persist($wish);
             $entityManager->flush();

             $this->addFlash('Success','Tu as réussi tu es trop fort !');

             //redirige vers la page d'accueil
             return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
         }

         // afficher le formulaire
         return $this->render('Formulaire/create.html.twig', ['wishForm' => $wishForm->createView()]);

     }
}