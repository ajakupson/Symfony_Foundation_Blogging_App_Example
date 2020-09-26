<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Entity\BlogPosts;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;

class BlogPageController extends AbstractController
{
    public function userBlogPage($userId)
    {
        $usersRepo = $this->getDoctrine()->getRepository(Users::class);
        $user = $usersRepo->findOneById($userId);

        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);
        $blogPosts = $blogPostsRepo->getPostsByUserId($userId);

        return $this->render('pages/blog-page.html.twig', ['user' => $user, 'blogPosts' => $blogPosts]);
    }

    function blogAddPostPage($userId) {
      $usersRepo = $this->getDoctrine()->getRepository(Users::class);
      $user = $usersRepo->findOneById($userId);

      return $this->render('pages/blog-post-page-add.html.twig', ['user' => $user]);
    }

    function blogAddPost($userId, Request $request, FileUploader $fileUploader) {
      $usersRepo = $this->getDoctrine()->getRepository(Users::class);
      $user = $usersRepo->findOneById($userId);

      $title = $request->request->get('post-title');
      $content = $request->request->get('post-content');
      $file = $request->files->get('post-img');

      $blogPost = new BlogPosts();
      $blogPost->setDateTime(new \DateTime());
      $blogPost->setTitle($title);
      $blogPost->setContent($content);
      $blogPost->setUser($user);

      if($file) {
        $fileName = $fileUploader->upload($file);
        $blogPost->setPostImg($fileName);
      }

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($blogPost);
      $entityManager->flush();

      $response = new Response(json_encode("{}"));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }
}

?>
