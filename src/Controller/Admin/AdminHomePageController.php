<?php

namespace App\Controller\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHomePageController extends AbstractController
{
    public function adminHomePage()
    {
        return $this->render('pages/admin-home-page.html.twig');
    }
}

?>
