<?php

namespace My\BasketBundle\Utils;

use Symfony\Component\HttpFoundation\Session\Session;

class Basket 
{
    const BASKET_CONTAINER = 'basketContainer';

    private $basketContainer = array(); 

    private $session; 

    public function __construct(Session $session) 
    {
        $this->session = $session;     
        
        if($this->session->has(Basket::BASKET_CONTAINER)) {
            $this->basketContainer = $this->session->get(Basket::BASKET_CONTAINER);
        } else { 
            $this->basketContainer = array();
        }
    }

    public function saveState() 
    {
        $this->session->set(Basket::BASKET_CONTAINER, $this->basketContainer);
    }

    public function addToBasket(array $item) 
    { 
        if(!array_key_exists($item['id'], $this->basketContainer)) { 
            $this->basketContainer[$item['id']] = array('item' => $item, 'count' => 1);
        } else { 
            $this->basketContainer[$item['id']]['count']++;
        }

        $this->basketContainer[$item['id']]['value'] = $item['price'] * $this->basketContainer[$item['id']]['count']; 

        $this->saveState();
    }

    public function removeFromBasket($id) 
    {
        unset($this->basketContainer[$id]);

        $this->saveState();
    }

    public function clearBasket() 
    {
        $this->basketContainer = array();

        $this->saveState();
    }

    public function getContents() 
    {
        return $this->basketContainer; 
    }

    public function getTotalValue() 
    {
        $totalValue = 0; 

        foreach($this->basketContainer as $item) { 
            $totalValue += $item['value'];
        }

        return $totalValue; 
    }

    public function __destruct()
    {
        $this->saveState();
    }
}
