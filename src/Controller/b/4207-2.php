<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
//use App\Entity\acces;
//use App\Entity\Autorisation;
//use App\Entity\document;



//Permet d'utiliser doctrine pour travailler avec la base de donnée
use Doctrine\ORM\EntityManagerInterface;

//Gestion des variables de session et envoi de données au formulaire
use Symfony\Component\HttpFoundation\Request;

//Permet de convertir une chaine en DateTime
use Symfony\Component\Validator\constaints\DateTime;

class MonController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request): Response
    {
        return $this->render('mon/login.html.twig', [
            'controller_name' => 'MonController',
        ]);

        //Recupere les informations de inscription
        $nom = $request -> request -> get("nom") ;
        $prenom = $request -> request -> get("prenom") ;
        $pass = $request -> request -> get("password") ;

        //Creation d'un objet

        //Recherche l'utilisateur dans la base de donnée
        $utilisateur = $manager -> getRepository(Utilisateur::class)->findOneBy(['prenom'=>$prenom]);

        //Verifie le mot de passe
        if ($utilisateur == null){
            $message = "Utilisateur inconnue";

            }
            else{
            if($pass == $utilisateur->getPassword()){
                $message = "Utilisateur ok";
            }
            else{
                $message = "Mot de passe incorrect";
            }

        }

        //return new Response($message."Utilisateur ".$prenom);
        //session->set('userID',-1);

    }

    /**
     * @Route("/inscription", name="inscription")
     */

    public function inscription(Request $request, EntityManagerInterface $manager): Response{
    {

            //Recuperation des données saisies
            $nom=$request->request->get("nom");
            $prenom=$request->request->get("prenom");
            $email=$request->request->get("email");
            $password=$request->request->get("password");

            //Creation d'un objet Etudiant
            $monEtudiant = new Utilisateur();

            //Insertion de la valeur dans l'objet
            $monEtudiant -> setnom($nom);
            $monEtudiant -> setprenom($prenom);
            $monEtudiant -> setemail($email);
            $monEtudiant -> setpassword($password);

            //Utilisation de la percistance pour stocker l'objet
            $manager->persist($monEtudiant);
            $manager->flush();

            //Valeur de retour
            return new response("true");
            //return $this->redirectionToRoute ('Liste_Etudiants');

        }

    }


    /**
     * @Route("/cloud", name="cloud")
     */
    public function cloud(Request $request, EntityManagerInterface $manager): Response
    {
            return new response("true");

    }





    /**
     * @Route("/liste", name="liste")
     */
    public function liste_etudiants(EntityManagerInterface $manager): Response
    {
        $mesEtudiants=$manager->getRepository(Etudiant::class)->findall();
        return $this->render('mon/liste_etudiants.html.twig', [
            'etudiants' => $mesEtudiants,
        ]);

    }





}
