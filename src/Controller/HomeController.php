<?php

namespace App\Controller;

use App\Repository\DeviceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        //device count
        $devices=22;
        //user count
        $alarms=10;
        //telemetry count
        $tracked=10;

        return $this->render('home/index.html.twig', ['devices' => $devices,'alarms'=>$alarms,'tracked'=>$tracked]);

    }
}
