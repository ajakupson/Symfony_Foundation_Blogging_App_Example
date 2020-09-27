<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Entity\BlogPosts;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends AbstractController
{
    public function homePage(UserPasswordEncoderInterface $encoder, Request $request)
    {
        // Create admin user programmatically

        $entityManager = $this->getDoctrine()->getManager();

        /*
        $user = new Users();
        $user->setEmail("admin@mail.com");
        $user->setRoles(["ROLE_ADMIN"]);

        $plainPassword = 'qwerty';
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
        $blogPosts = Array();

        $currentPage = $request->request->get("current-page");
        if(!$currentPage ) {
          $currentPage = 1;
        }
        if($currentPage == 1) {
          $offset = 0;
        } else {
          $offset = (int)$currentPage - 2 + 6;
        }

        $searchWord = trim($request->request->get("search-word"));
        if(!$searchWord) {
          $blogPosts = $blogPostsRepo->getLatestPosts($offset);
        } else {
          $blogPosts = $blogPostsRepo->findByKeywordInTitleOrContent($searchWord, $offset);
        }

        $totalPosts = 0;
        if(!$searchWord) {
          $totalPosts = $blogPostsRepo->getPostsCount();
        } else {
          $totalPosts = $blogPostsRepo->getPostsCountByKeywordInTitleOrContent($searchWord);
        }

        return $this->render('pages/home-page.html.twig', ['users' => $users, 'blogPosts' => $blogPosts,
                                                           'searchWord' => $searchWord, 'totalPosts' => $totalPosts,
                                                           'currentPage' => $currentPage]);
    }
}

?>
