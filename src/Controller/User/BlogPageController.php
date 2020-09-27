<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Entity\BlogPosts;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;

class BlogPageController extends AbstractController
{
    public function userBlogPage($userId, Request $request)
    {
        $usersRepo = $this->getDoctrine()->getRepository(Users::class);
        $user = $usersRepo->findOneById($userId);

        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);

        $currentPage = $request->request->get("current-page");
        if(!$currentPage ) {
          $currentPage = 1;
        }
        if($currentPage == 1) {
          $offset = 0;
        } else {
          $offset = (int)$currentPage - 2 + 8;
        }

        $blogPosts = Array();
        $searchWord = trim($request->request->get("search-word"));
        if(!$searchWord) {
          $blogPosts = $blogPostsRepo->getPostsByUserId($userId, $offset, $maxResult = 8);
        } else {
          $blogPosts = $blogPostsRepo->findByKeywordAndUserIdInTitleOrContent($userId, $searchWord, $offset, $maxResult = 8);
        }

        $totalPosts = 0;
        if(!$searchWord) {
          $totalPosts = $blogPostsRepo->getPostsCountByUserId($userId);
        } else {
          $totalPosts = $blogPostsRepo->getPostsCountByKeywordInTitleOrContentAndUserId($userId, $searchWord);
        }

        return $this->render('pages/blog-page.html.twig', ['user' => $user, 'blogPosts' => $blogPosts,
                                                           'searchWord' => $searchWord, 'totalPosts' => $totalPosts,
                                                           'currentPage' => $currentPage]);
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
