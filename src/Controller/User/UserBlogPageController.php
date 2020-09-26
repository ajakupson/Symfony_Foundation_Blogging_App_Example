<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Entity\BlogPosts;

class UserBlogPageController extends AbstractController
{
    public function userBlogPage($userId)
    {
        $usersRepo = $this->getDoctrine()->getRepository(Users::class);
        $user = $usersRepo->findOneById($userId);

        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);
        $blogPosts = $blogPostsRepo->getPostsByUserId($userId);

        return $this->render('pages/user-blog-page.html.twig', ['user' => $user, 'blogPosts' => $blogPosts]);
    }
}

?>
