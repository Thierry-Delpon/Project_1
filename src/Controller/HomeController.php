<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route (name="home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route (path="", name="index", methods={"GET"})
     */
    public function index(){
        return $this->render('Home/index.html.twig');
    }

    /**
     * @Route (path="contact", name="contact", methods={"GET"})
     */
    public function contact(){
        return $this->render('Home/contact.html.twig');
    }

    /**
     * @Route (path="about", name="about", methods={"GET"})
     */
    public function lorem(){
        return $this->render('AboutUs/About.html.twig');
    }
}