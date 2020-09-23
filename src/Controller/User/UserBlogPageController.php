<?php

namespace App\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBlogPageController extends AbstractController
{
    public function userBlogPage()
    {
        return $this->render('pages/user-blog-page.html.twig');
    }
}

?>
