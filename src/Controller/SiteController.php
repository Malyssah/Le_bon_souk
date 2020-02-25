<? php

espace de noms  App \ Controller ;

utilisez  App \ Entity \ Image ;
utiliser  App \ Entity \ Annonce ;
utilisez  App \ Form \ ImageType ;
utilisez  App \ Entity \ Rubrique ;
utilisez  App \ Form \ AnnonceType ;
utilisez  App \ Repository \ RubriqueRepository ;
utiliser  Doctrine \ ORM \ EntityManagerInterface ;
utilisez  Symfony \ Component \ HttpFoundation \ Request ;
utilisez  Symfony \ Component \ Routing \ Annotation \ Route ;
utilisez  Symfony \ Component \ Security \ Core \ User \ UserInterface ;
utilisez  Symfony \ Component \ Form \ Extension \ Core \ Type \ ChoiceType ;
utilisez  Symfony \ Bundle \ FrameworkBundle \ Controller \ AbstractController ;
utilisez  Symfony \ Component \ Form \ Extension \ Core \ Type \ SubmitType ;

classe  SiteController  étend  AbstractController
{
    / **
     * @Route ("/ index", name = "site")
     * /
     indice de fonction  publique ()
    {

        return  $ this -> redirectToRoute ( "home" );
        
    }

    / **
     * Accueil + Lister Rubriques
     * 
     * @Route ("/", name = "home")
     * /
     accueil de la fonction  publique ( RubriqueRepository $ repo , Request $ request , EntityManagerInterface $ em )   
    {

        $ rub = nouvelle  Rubrique ();

        $ repo = $ this -> getDoctrine () -> getRepository ( Rubrique :: class);

        $ rubriques = $ repo -> findAll ();

        

        $ form = $ this -> createFormBuilder ( $ rub )
            -> add ( 'libelle' , ChoiceType :: class, [
                'choix' => $ rubriques ,
                'choice_value' => 'id' ,
                'choice_label' => fonction ( $ rub , $ key , $ value ) {
                return  $ rub -> getLibelle ();
            }
            ])
            -> add ( 'save' , SubmitType :: class, [ 'label' => 'Rechercher' ])
            -> getForm ();
            
            $ form -> handleRequest ( $ request );

            
            
        if ( $ form -> isSubmitted () && $ form -> isValid ())
        {
            $ annonce = new  Annonce ();
            $ repository = $ em -> getRepository ( Annonce :: class);
            $ ann = $ repository -> findByRubid ( $ _POST [ 'form' ] [ 'libelle' ]);
            

           
            

            retourne  $ this -> render ( 'site / home.html.twig' , [
                'form' => $ form -> createView (),
                'ann' => $ ann
            ]);}

        
        

        sinon {
        retourne  $ this -> render ( 'site / home.html.twig' , [
            'form' => $ form -> createView (),
            'annonces' => 'Veuillez choisir une rubrique pour voir les annonces correspondantes' ,
            'ann' => "Aucune donnée n'est présente"
        ]);}
    }

    / **
     * @Route ("annonce / create", name = "creation")
     * /
     fonction  publique create ( Annonce  $ annonce = null , Request  $ request , EntityManagerInterface  $ manager ) {
        if (! $ annonce ) {
        $ annonce = new  Annonce ();

        }
        $ image = new  Image ();
        $ date = date ( "Ymd" );
        $ date2 = new \ Datetime ();
        $ form = $ this -> createform ( AnnonceType :: class, $ annonce );
        $ form2 = $ this -> createform ( ImageType :: class, $ image );
        $ repo = $ manager -> getRepository ( Rubrique :: class);
        $ rub = $ repo -> findAll ();
        $ form -> handleRequest ( $ request );
        $ id = '' ;
        if ( $ form -> isSubmitted () && $ form -> isValid ()) {
            // retourne une nouvelle réponse (var_dump ($ form-> getData ()));


            $ manager -> persist ( $ annonce );
            $ annonce -> setDateCreation ( $ date2 );
            $ annonce -> setRubId ( $ _POST [ "rubrique" ]);
 
            $ manager -> flush ();
            $ id = $ annonce -> getId ();
            $ ext2 = $ request -> files -> get ( 'annonce' );
            if (! empty ( $ ext2 [ 'Image' ])) {
            $ ext = $ ext2 [ 'Image' ] -> getClientOriginalExtension ();

            $ uploadFile = $ form [ 'Image' ] -> getData ();
            $ destination = $ this -> getParameter ( 'kernel.project_dir' ). '/ public / uploads /' . $ id ;
            $ OriginalFilename = pathinfo ( $ UploadedFile -> getClientOriginalName (), PATHINFO_FILENAME );

            $ uploadFile -> move (
                $ destination ,
                $ originalFilename
            );
        
            renommer ( 'D: / www / Le_bon_souk-master / a / public / uploads /' . $ id . "/" . $ originalFilename , 'D: / www / Le_bon_souk-master / a / public / uploads /' . $ id . "/" . $ originalFilename . "." . $ ext );
            $ newfilename = $ originalFilename . "." . $ ext ;
            $ href = "uploads /" . $ id . "/" . $ newfilename ;
            $ image -> setname ( $ href );
            $ image -> setannID ( $ id );
            $ manager -> persist ( $ image );
            $ manager -> flush ();
        }
        }
        return  $ this -> render ( "site / form.html.twig" , [ 'formAnnonce' => $ form -> createview (), 'Imageform' => $ form2 , 'editmode' => $ annonce -> getId ( )! == null , 'date' => $ date , "rubrique" => $ rub ]);
    }

    / **
     * @Route ("annonce / edit / {id}", name = "edit")
     * /
     fonction  publique edit ( Annonce  $ annonce = null , Request  $ request , EntityManagerInterface  $ manager ) {
        if (! $ annonce ) {
        $ annonce = new  Annonce ();

        }
        $ image = new  Image ();
        $ date = date ( "Ymd" );
        $ date2 = new \ Datetime ();
        $ form = $ this -> createform ( AnnonceType :: class, $ annonce );
        $ form2 = $ this -> createform ( ImageType :: class, $ image );
        $ repo = $ manager -> getRepository ( Rubrique :: class);
        $ rub = $ repo -> findAll ();
        $ form -> handleRequest ( $ request );
        $ id = '' ;
        if ( $ form -> isSubmitted () && $ form -> isValid ()) {
            // retourne une nouvelle réponse (var_dump ($ form-> getData ()));


            $ manager -> persist ( $ annonce );
            $ annonce -> setDateCreation ( $ date2 );
            $ annonce -> setRubId ( $ _POST [ "rubrique" ]);
 
            $ manager -> flush ();
            $ id = $ annonce -> getId ();
            $ ext2 = $ request -> files -> get ( 'annonce' );
            if (! empty ( $ ext2 [ 'Image' ])) {
            $ ext = $ ext2 [ 'Image' ] -> getClientOriginalExtension ();

            $ uploadFile = $ form [ 'Image' ] -> getData ();
            $ destination = $ this -> getParameter ( 'kernel.project_dir' ). '/ public / uploads /' . $ id ;
            $ OriginalFilename = pathinfo ( $ UploadedFile -> getClientOriginalName (), PATHINFO_FILENAME );

            $ uploadFile -> move (
                $ destination ,
                $ originalFilename
            );
        
            rename ( 'D: / www / test / le_bon_souk_project / le_bon_souk_project / public / uploads /' . $ id . "/" . $ originalFilename , 'D: / www / test / le_bon_souk_project / le_bon_souk_project / public / uploads /' . $ id . "/" . $ originalFilename . "." . $ ext );
            $ newfilename = $ originalFilename . "." . $ ext ;
            $ href = "uploads /" . $ id . "/" . $ newfilename ;
            $ image -> setname ( $ href );
            $ image -> setannID ( $ id );
            $ manager -> persist ( $ image );
            $ manager -> flush ();
        }
        }
        return  $ this -> render ( "site / formEdit.html.twig" , [ 'formAnnonce' => $ form -> createview (), 'Imageform' => $ form2 , 'editmode' => $ annonce -> getId ( )! == null , 'date' => $ date , "rubrique" => $ rub ]);
    }

    / **
     * @Route ("annonce / {id} / liste", name = "liste")
     * /
     liste des fonctions  publiques ( EntityManagerInterface $ em ) { 
        $ annonce = new  Annonce ();
        $ repository = $ em -> getRepository ( Annonce :: class);
        $ ann = $ repository -> findByrubid ( $ _POST [ 'id' ]);
        



       return  $ this -> render ( "site / liste.html.twig" , [ "annonce" => $ ann ]);
    }
/ **
     * @Route ("annonce / show / {id}", name = "show")
     * /
     fonction  publique show ( EntityManagerInterface  $ em ) {
        $ annonce = new  Annonce ();
        $ repository = $ em -> getRepository ( Annonce :: class);
        $ ann = $ repository -> findById ( $ _POST [ 'id' ]);
        // un spectacle de brindilles
        $ repo = $ em -> getRepository ( Image :: class);
        $ image = $ repo -> findByannid ( $ _POST [ 'id' ]);


        return  $ this -> render ( "site / listePrecise.html.twig" , [ "annonce" => $ ann , 'show' => 'exist' , 'image' => $ image ]);
    }

    / **
     * @Route ("annonce / show", name = "showAnnonce")
     * /
    publique  fonction  showAnnonce ( EntityManagerInterface  $ em ) {
        $ annonce = new  Annonce ();
        $ repository = $ em -> getRepository ( Annonce :: class);
        $ ann = $ repository -> findById ( $ _GET [ 'id' ]);
        // un spectacle de brindilles
        $ repo = $ em -> getRepository ( Image :: class);
        $ image = $ repo -> findByannid ( $ _GET [ 'id' ]);


        return  $ this -> render ( "site / listePrecise.html.twig" , [ "annonce" => $ ann , 'show' => 'exist' , 'image' => $ image ]);
    }

    / **
     * @Route ("annonce / delete / {id}", name = "delete")
     * /

      suppression de fonction  publique ( EntityManagerInterface $ em ) { 
        $ repository = $ em -> getRepository ( Annonce :: class);
        $ ann = $ repository -> findById ( $ _POST [ 'id' ]);
        if (! empty ( $ _POST [ 'iduser' ])) {
        if ( $ ann [ 0 ] -> getUserid () == $ _POST [ 'iduser' ]) {
        $ em -> remove ( $ ann [ 0 ]);
        $ em -> flush ();
        retourner  $ this -> render ( "site / delete.html.twig" );
        }
        sinon {
            retourne  $ this -> render ( 'site / home.html.twig' , [
                'controller_name' => 'RubriquesController' ,
                'rubriques' => $ rubriques
            ]);
        }
    }
    sinon {
        $ repo = $ this -> getDoctrine () -> getRepository ( Rubrique :: class);

        $ rubriques = $ repo -> findAll ();
        retourne  $ this -> render ( 'site / home.html.twig' , [
            'controller_name' => 'RubriquesController' ,
            'rubriques' => $ rubriques
        ]);
    }
     }
  
    / **
     * @Route ("annonce / listeMine", name = "Liste_mine")
     * /

     publique  fonction  listeMine ( EntityManagerInterface  $ em , InterfaceUtilisateur  $ utilisateur ) {
        if ( $ this -> getUser () -> getId () == $ _GET [ 'id' ]) {
        $ repository = $ em -> getRepository ( Annonce :: class);
        $ ann = $ repository -> findByuserid ( $ _GET [ 'id' ]);
        if ( vide ( $ ann )) {
            return  $ this -> redirectToRoute ( "home" );
        }
        foreach ( $ ann  as  $ key => $ value ) {
        $ repo = $ em -> getRepository ( Image :: class);
        $ images = $ repo -> findByannid ( $ value -> getID ());
        if (! vide ( $ images )) {
            $ image [] = $ images [ 0 ];
        }

        if ( vide ( $ image )) {
            return  $ this -> render ( "site / liste.html.twig" , [ "annonce" => $ ann ]);
        }
        
        }
        
 
        return  $ this -> render ( "site / liste.html.twig" , [ "annonce" => $ ann , 'show' => 'exist' , 'image' => $ image ]);
        }
    sinon {
        $ repo = $ this -> getDoctrine () -> getRepository ( Rubrique :: class);

        $ rubriques = $ repo -> findAll ();
        retourne  $ this -> render ( 'site / home.html.twig' , [
            'controller_name' => 'RubriquesController' ,
            'rubriques' => $ rubriques
        ]);
    }
     }

}
