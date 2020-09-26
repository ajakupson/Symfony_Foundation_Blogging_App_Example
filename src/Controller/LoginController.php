<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    public function loginCheck()
    {
      return $this->json(['user' => $this->getUser() ? $this->getUser()->getId() : null]);
    }
}

?>
