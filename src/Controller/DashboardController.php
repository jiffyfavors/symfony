<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    
    /**
     * @Route("/dashboard")
     */

     public function dashboard():Response
     {
     $number = 1;
     return $this->render('dashboard/dashboard.html.twig', [
            'number' => $number,
        ]);
     }

}
