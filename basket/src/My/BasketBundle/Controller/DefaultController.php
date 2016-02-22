<?php

namespace My\BasketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public $items = array(
        '1' => array('id' => 1, 'name' => 'Chair',      'price' => 10), 
        '2' => array('id' => 2, 'name' => 'Table',      'price' => 20), 
        '3' => array('id' => 3, 'name' => 'Window',     'price' => 30),
    );

    public function indexAction()
    {
        return $this->render('MyBasketBundle:Default:index.html.twig', array(
            'items' => $this->items,
            'basket' => $this->get('my.basket')->getContents(),
            'basketTotalValue' => $this->get('my.basket')->getTotalValue(),      
        ));
    }

    public function addItemAction($id) 
    { 
        if(array_key_exists($id, $this->items)) { 
            $this->get('my.basket')->addToBasket($this->items[$id]); 
        }

        return $this->redirect($this->generateUrl('my_basket_index'));
    }

    public function removeItemAction($id) 
    {
        $this->get('my.basket')->removeFromBasket($id);

        return $this->redirect($this->generateUrl('my_basket_index'));
    }

    public function clearBasketAction()
    {
        $this->get('my.basket')->clearBasket();

        return $this->redirect($this->generateUrl('my_basket_index'));
    }
}
