<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    public function result(): Response
    {
        return $this->render('site/result.html.twig');
    }

    public function statistics(): Response
    {
        return $this->render('site/statistics.html.twig');
    }
}