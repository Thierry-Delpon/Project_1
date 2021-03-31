<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="product/", name="product_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route(path="get/{id}-{dpt}",requirements={"id":"\d+","dpt":"\d+"}, name="obtain", methods={"GET"})
     */
    public function obtain(Request $request){

        $product_id = $request->get('id');
        $product_dpt = $request->get('dpt');
        $save = $request->get('save');
        return $this->render('Produit/produit.html.twig', compact('product_id','product_dpt','save'));
    }
}