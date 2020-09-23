<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;

class HomePageController extends AbstractController
{
    public function homePage()
    {
        // Create admin user programmatically
        /*
        $entityManager = $this->getDoctrine()->getManager();
        $user = new Users();
        $user->setEmail("ajakupson.job@gmail.com");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('qwerty500');
        $user->setFirstName("Andrei");
        $user->setLastName("Jakupson");
        $entityManager->persist($user);
        $entityManager->flush();
        */

        $usersRepo = $this->getDoctrine()->getRepository(Users::class);
        $users = $usersRepo->findAll();

        return $this->render('pages/home-page.html.twig', ['users' => $users]);
    }
}

?>
