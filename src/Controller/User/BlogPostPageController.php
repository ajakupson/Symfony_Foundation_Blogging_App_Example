<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Entity\BlogPosts;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\PostComments;

class BlogPostPageController extends AbstractController
{
    public function blogPostPage($userId, $postId)
    {
        $usersRepo = $this->getDoctrine()->getRepository(Users::class);
        $user = $usersRepo->findOneById($userId);

        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);
        $blogPost = $blogPostsRepo->getPostById($postId);

        return $this->render('pages/blog-post-page.html.twig', ['user' => $user, 'blogPost' => $blogPost, 'comments' => $blogPost->getPostComments()]);
    }

    public function updateBlogPost($postId, Request $request)
    {
        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);
        $blogPost = $blogPostsRepo->getPostById($postId);

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $blogPost->setTitle($parametersAsArray["newTitle"]);
        $blogPost->setContent($parametersAsArray["newContent"]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($blogPost);
        $entityManager->flush();

        $response = new Response(json_encode("{}"));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function addComment($postId, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $comment = new PostComments();

        $blogPostsRepo = $this->getDoctrine()->getRepository(BlogPosts::class);
        $blogPost = $blogPostsRepo->getPostById($postId);
        $comment->setPost($blogPost);

        if($parametersAsArray["userId"]) {
          $usersRepo = $this->getDoctrine()->getRepository(Users::class);
          $user = $usersRepo->findOneById($parametersAsArray["userId"]);
          $comment->setUser($user);
        }
        $comment->setComment($parametersAsArray["commentTxt"]);
        $comment->setIsHidden(false);
        $comment->setDateTime(new \DateTime());

        $entityManager->persist($comment);
        $entityManager->flush();

        $response = new Response(json_encode("{}"));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

?>
