<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Annonce;
use App\Form\ImageType;
use App\Entity\Rubrique;
use App\Form\AnnonceType;
use App\Repository\RubriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SiteController extends AbstractController
{
    /**
     * @Route("/index", name="site")
     */
    public function index()
    {

        return $this->redirectToRoute("home");
        
    }

    /**
     * Home + Lister Rubriques
     * 
     * @Route("/", name="home")
     */
    public function home(RubriqueRepository $repo, Request $request, EntityManagerInterface $em)
    {

        $rub = new Rubrique();

        $repo = $this->getDoctrine()->getRepository(Rubrique::class);

        $rubriques = $repo->findAll();

        

        $form = $this->createFormBuilder($rub)
            ->add('libelle', ChoiceType::class, [
                'choices' => $rubriques,
                'choice_value' => 'id',
                'choice_label' => function($rub, $key, $value) {
                return $rub->getLibelle();
            }
            ])
            ->add('save', SubmitType::class, ['label' => 'Rechercher'])
            ->getForm();
            
            $form->handleRequest($request);

            
            
        if ($form->isSubmitted() && $form->isValid())
        {
            $annonce= new Annonce();
            $repository=$em->getRepository(Annonce::class);
            $ann=$repository->findByRubid($_POST['form']['libelle']);
            

           
            

            return $this->render('site/home.html.twig', [
                'form' => $form->createView(),
                'ann' => $ann
            ]);}

        
        

        else{
        return $this->render('site/home.html.twig', [
            'form' => $form->createView(),
            'annonces' => 'Veuillez choisir une rubrique pour voir les annonces correspondantes',
            'ann' => "Aucune donnée n'est présente"
        ]);}
    }

    /**
     * @Route("annonce/create", name="creation")
     */
    public function create(Annonce $annonce = null, Request $request, EntityManagerInterface $manager){
        if(!$annonce){
        $annonce= new Annonce();

        }
        $image= new Image();
        $date=date("Y-m-d");
        $date2=new \Datetime();
        $form=$this->createform(AnnonceType::class, $annonce);
        $form2=$this->createform(ImageType::class, $image);
        $repo=$manager->getRepository(Rubrique::class);
        $rub=$repo->findAll();
        $form->handleRequest($request);
        $id='';
        if($form->isSubmitted()&& $form->isValid()){
            // return new Response(var_dump($form->getData()));
            $manager->persist($annonce);
            $annonce->setDateCreation($date2);
            $annonce->setRubId($_POST["rubrique"]);
 
            $manager->flush();
            $id=$annonce->getId();
            $ext2=$request->files->get('annonce');
            if(!empty($ext2['Image'])){
            $ext=$ext2['Image']->getClientOriginalExtension();

            $uploadedFile = $form['Image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$id;
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

            $uploadedFile->move(
                $destination,
                $originalFilename
            );
        
            rename('C:\wamp64\www\test symfony\Le_bon_souk\public\uploads/'.$id."/".$originalFilename, 'C:\wamp64\www\test symfony\Le_bon_souk\public\uploads/'.$id."/".$originalFilename.".".$ext);
            $newfilename=$originalFilename.".".$ext;
            $href="uploads/".$id."/".$newfilename;
            $image->setname($href);
            $image->setannID($id);
            $manager->persist($image);
            $manager->flush();
        }
        }
        return $this->render("site/form.html.twig", ['formAnnonce'=>$form->createview(),'Imageform'=>$form2, 'editmode'=> $annonce->getId()!==null, 'date'=>$date, "rubrique"=>$rub]);
    }

    /**
     * @Route("annonce/edit/{id}", name="edit")
     */
    public function edit(Annonce $annonce = null, Request $request, EntityManagerInterface $manager){
        if(!$annonce){
        $annonce= new Annonce();

        }
        $image= new Image();
        $date=date("Y-m-d");
        $date2=new \Datetime();
        $form=$this->createform(AnnonceType::class, $annonce);
        $form2=$this->createform(ImageType::class, $image);
        $repo=$manager->getRepository(Rubrique::class);
        $rub=$repo->findAll();
        $form->handleRequest($request);
        $id='';
        if($form->isSubmitted()&& $form->isValid()){
            // return new Response(var_dump($form->getData()));


            $manager->persist($annonce);
            $annonce->setDateCreation($date2);
            $annonce->setRubId($_POST["rubrique"]);
 
            $manager->flush();
            $id=$annonce->getId();
            $ext2=$request->files->get('annonce');
            if(!empty($ext2['Image'])){
            $ext=$ext2['Image']->getClientOriginalExtension();

            $uploadedFile = $form['Image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$id;
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

            $uploadedFile->move(
                $destination,
                $originalFilename
            );
        
            rename('C:\wamp64\www\test symfony\Le_bon_souk\public\uploads/'.$id."/".$originalFilename, 'C:\wamp64\www\test symfony\Le_bon_souk\public\uploads/'.$id."/".$originalFilename.".".$ext);
            $newfilename=$originalFilename.".".$ext;
            $href="uploads/".$id."/".$newfilename;
            $image->setname($href);
            $image->setannID($id);
            $manager->persist($image);
            $manager->flush();
        }
        }
        return $this->render("site/formEdit.html.twig", ['formAnnonce'=>$form->createview(),'Imageform'=>$form2, 'editmode'=> $annonce->getId()!==null, 'date'=>$date, "rubrique"=>$rub]);
    }

    /**
     * @Route("annonce/{id}/liste", name="liste")
     */
    public function liste(EntityManagerInterface $em){
        $annonce= new Annonce();
        $repository=$em->getRepository(Annonce::class);
        $ann=$repository->findByrubid($_POST['id']);
        



       return $this->render("site/liste.html.twig", ["annonce"=>$ann]); 
    }
/**
     * @Route("annonce/show/{id}", name="show")
     */
    public function show(EntityManagerInterface $em){
        $annonce= new Annonce();
        $repository=$em->getRepository(Annonce::class);
        $ann=$repository->findById($_POST['id']);
        //a faire twig show
        $repo=$em->getRepository(Image::class);
        $image=$repo->findByannid($_POST['id']);


        return $this->render("site/listePrecise.html.twig", ["annonce"=>$ann, 'show'=>'exist', 'image'=>$image]);
    }

    /**
     * @Route("annonce/delete/{id}", name="delete")
     */

     public function delete(EntityManagerInterface $em){
        $repository=$em->getRepository(Annonce::class);
        $ann=$repository->findById($_POST['id']);
        if(!empty($_POST['iduser'])){
        if ($ann[0]->getUserid() == $_POST['iduser']){
        $em->remove($ann[0]);
        $em->flush();
        return $this->render("site/delete.html.twig");
        }
        else{
            return $this->render('site/home.html.twig', [
                'controller_name' => 'RubriquesController',
                'rubriques' => $rubriques
            ]);
        }
    }
    else{
        $repo = $this->getDoctrine()->getRepository(Rubrique::class);

        $rubriques = $repo->findAll();
        return $this->render('site/home.html.twig', [
            'controller_name' => 'RubriquesController',
            'rubriques' => $rubriques
        ]);
    }
     }
  
    /**
     * @Route("annonce/listeMine", name="Liste_mine")
     */

     public function listeMine(EntityManagerInterface $em, UserInterface $user){
        if ($this->getUser()->getId()==$_GET['id']){
        $repository=$em->getRepository(Annonce::class);
        $ann=$repository->findByuserid($_GET['id']);
        if(empty($ann)){
            return $this->redirectToRoute("home");
        }
        foreach($ann as $key=>$value){
        $repo=$em->getRepository(Image::class);
        $images=$repo->findByannid($value->getID());
        if(!empty($images)){
            $image[]=$images[0];
        }

        if(empty($image)){
            return $this->render("site/liste.html.twig", ["annonce"=>$ann]); 
        }
        
        }
        
 
        return $this->render("site/liste.html.twig", ["annonce"=>$ann, 'show'=>'exist', 'image'=>$image]); 
        }
    else{
        $repo = $this->getDoctrine()->getRepository(Rubrique::class);

        $rubriques = $repo->findAll();
        return $this->render('site/home.html.twig', [
            'controller_name' => 'RubriquesController',
            'rubriques' => $rubriques
        ]);
    }
     }

}

