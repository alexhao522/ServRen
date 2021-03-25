<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Gestion des varirables de session et envoi de données au formulaire
use Symfony\Component\HttpFoundation\Request;

// Permet d'utilisater doctrine pour travailler avec la base de données
use Doctrine\ORM\EntityManagerInterface;

// Gestion des sessions
use Symfony\Component\HttpFoundation\Session\SessionInterface;

// Importe les réprésentation objet des tables
use App\Entity\Utilisateur;
use App\Entity\Acces;
use App\Entity\Autorisation;
use App\Entity\Genre;



class ServeurController extends AbstractController
{
    /**
     * @Route("/serveur", name="serveur")
     */
    public function index(): Response
    {
        $vs=$session->get('userid');

            if($vs == 0){
                return $this->render('serveur/index.html.twig', [
                    'controller_name' => 'page de Login',
                ]);
            }
            else{
                $utilisateur = $manager ->getRepository(Utilisateurs::class)->findOneBy(array('id' => $vs));
                return $this->render('serveur/reponse.html.twig', [
                    'controller_name' => 'ServeurController',
                    'utilisateur' => $utilisateur
    
                ]);
            }
    }

    /**
     * @Route("/signin", name="/signin")
     */
    public function utilisateurs(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {

        return $this->render('serveur/signin.html.twig', [
            'controller_name' => 'ServeurController',
        ]);
    }


    /**
     * @Route("/login", name="/login")
     */
    public function login(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $Login= $request->request->get('email');
        $Password= $request->request->get('password');
        $utilisateur = $manager ->getRepository(utilisateurs::class)->findOneBy(array('email' => $Login,'password' => $Password));
        if ($Login=="admin")
            $message="Vous êtes administrateur";
        else
            $message="Vous êtes utilisateur";

        if($utilisateur != NULL){
            $val =$utilisateur->getid();
            $session->set('userid',$val);
            return $this->render('serveur/reponse.html.twig', [
                'message' => $message,
                'controller_name' => 'ServeurController',
                'utilisateur' => $utilisateur
            ]);
        }
        else{
            $session->set('userid',0);
            return $this->redirectToRoute('serveur');
            
        }
    }

    public function signin(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $recupNom=$request->request->get('nom');
        $recupPrenom=$request->request->get('prenom');
        $recupEmail=$request->request->get('email2');
        $recupPassword=$request->request->get('password');
        
        $User = new Utilisateurs();
		$User->setNom($recupNom);
		$User->setPrenom($recupPrenom);
        $User->setEmail($recupEmail);
        $User->setPassword($recupPassword);
        $manager->persist($User);
		$manager->flush();
     
        return $this->redirectToRoute('listeUser');
    }



    /**public function majEtudiant(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
       // LoggerInterface $logger.Request $request.EntityManagerInterface $manager): Response
	//Récupération des données saisies
	{
		$nom=$request->request->get("nom");
		$prenom=$request->request->get("prenom");
		$telephone=$request->request->get("telephone");
		$adresse=$request->request->get("adresse");
		$dateNaissance=$request->request->get("datenaissance");
		$id-$request->request->get("Id");
		
		if ($nom == "admin")
			$message = "vous être admin";
		else 
			$message = "vous être utilisateur";
	}
	// Récupère l'objet formation associée

	//$objFormation 
	
	// mise à jour de l'objet
	if ($mode == "Insérer")
	// Création d'un objet étudiant
	$monEtudiant = new Etudiant();
	else 
	// modification d'un objet formation exisitant
	$monEtudiant - $manager -> getRepository(Etudiant::class)->findOneById($id);
	$monEtudiant->setNom($nom);
	$monEtudiant->setPrenom($prenom);
	
*/

	       
    /**
     * @Route("/listeUser", name="listeUser")
     */
    public function listeUser(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {
            $userid=$session->get('userid');
            if ($userid>0){
                $listUser=$manager->getRepository(signin::class)->findAll();

            return $this->render('serveur/listeUser.html.twig', [
                'listUser' => $listUser
            ]);
            }
            else{
                return new Response("Vous n'êtes pas connecté");
            }
    }


     /*   public function majFichier(Request $request,EntityManagerInterface $manager, SessionInterface $session):Response
        $utilisateur=$this->utilisateurConnecte ($manager, $session);

        if ($utilisateur){
            //Récupération des données saisies
            $typef=$request->request->get("typef");
            $id=$request->request->get("id");
            $mode=$request->request->get("mode");
            //Récupère l'objet Genre associé
            $genre=$manager->getRepository(Genre::class)->findOneById($typef);

            //Déplacement du fichier
            //a- Crée le répertoir de base si nécessaire
            $base='/Users/renxi/ServRen/public';
            if (file_exists($base)==false)
                mkdir($base);
            //b- Crée le répertoir du genre si nécessaire
            $base= $base.'/'.$genre->getType();
            $dest2=$genre->getType();
            if (file_exists($base)==false)
                mkdir($base);
            //c- Recopie le fichier
            $dest=$base.'/'.basename($_FILES['fichier']['name']);
            $dest2=$dest2.'/'.basename($_FILES['fichier']['name']);
            if(move_uploaded_file($_FILES['fichier']['tmp_name'],$dest)==false)
                return new Response("Echec téléchargement.".$nom." = ".$FILES['fichier']['tmp_name']." -> ")
            //Mise à jour de l'objet
            if($mode=="Insérer")
                //Création d'un objet Document
                $monDocument=new Document();
            else{
                //Modification d'un objet utilisateur existant
                $monDocument=$manager -> getRepository(Document::class)->findOneById($id);
                //Efface l'ancien fichier
                unlink($monDocument -> getChemin());
            }
            
            $monDocument -> setChemin($dest2);
            $monDocument -> setTypeId($genre);
            $monDocument -> setDate(new \DateTime("now"));
            $monDocument -> setActif(true);

            //Utilisation de la persistance pour stocker l'objet
            $manager -> persist($monDocument);
            $manager -> flush();

            //Crée un accès au document pour son créateur (s'il ne s'agit pas d'une mise à jour)
            if ($mode=="insérer"){
                $monAcces = new Acces();
                $monAcces -> setUtilisateurId($utilisateur0;
                )

            }



        }*/
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {
            $session->clear();
            return $this->redirectToRoute('mon');    
    }


}