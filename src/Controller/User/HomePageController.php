<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Entity\BlogPosts;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomePageController extends AbstractController
{
    public function homePage(/*UserPasswordEncoderInterface $encoder*/)
    {
        // Create admin user programmatically
        /*
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $user->setEmail("ajakupson@gmail.com");
        $user->setRoles(["ROLE_ADMIN"]);

        $plainPassword = 'qwerty500';
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);

        $user->setFirstName("Andrei");
        $user->setLastName("Jakupson");

        $entityManager->persist($user);
        $entityManager->flush();
        */

        $usersRepo = $this->getDoctrine()->getRepository(Users::class);
        $users = $usersRepo->findAll();

        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);
        $blogPosts = $blogPostsRepo->getLatestPosts();

        return $this->render('pages/home-page.html.twig', ['users' => $users, 'blogPosts' => $blogPosts]);
    }
}

?>
