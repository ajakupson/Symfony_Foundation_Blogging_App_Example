<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController
{
    public function logout(){
      $container->get('security.context')->setToken(null);
      $container->get('session')->invalidate();
    }
}

?>
