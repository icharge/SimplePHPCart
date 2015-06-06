<?php

/**
 * Simple Cart system for PHP and easy to use
 * use with SESSION
 * <b>Example:</b><br/>
 *   $_SESSION['cart'] = new Cart();<br/>
 *   $cart = &$_SESSION['cart'];<br/>
 * It can access by <b>$cart</b>
 * @author Norrapat Nimmanee
 * @version initial
 * @property Cart $cart
 */
class Cart implements Serializable {

    private $items;
    private $sessName = NULL;

    /**
     * The Cart Constructor
     * @param Array:Session $sessName give session name if need to store on Session.
     */
    function __construct() {
        $this->items = array();
    }

    /**
     * Set Session name for Cart store data
     * @param string $sessName
     */
    function setSessionName($sessName) {
        $this->sessName = $sessName;
    }

    /**
     * Save the Cart to Session
     */
    public function save() {
        if ($this->sessName != NULL) {
            $_SESSION[$this->sessName] = $this->serialize();
        }
    }

    /**
     * Load the Cart from Session
     * @param Array $obj Cart that serialized to Array form
     */
    public function load($obj) {
        $this->unserialize($obj);
        if ($this->sessName != NULL) {
            $this->save();
        }
    }

    public function serialize() {
        $vars = get_object_vars($this);
        return serialize($vars);
    }

    public function unserialize($serialized) {
        $vars = unserialize($serialized);
        foreach ($vars as $var => $value) {
            $this->$var = $value;
        }
    }

    /**
     * Get key from Cart by Product ID
     * @param mixed $productId
     * @return boolean
     */
    public function getKey($productId) {
        $ret = -1;
        foreach ($this->items as $key => $value) {
            if ($value->productId == $productId) {
                $ret = $key;
                break;
            }
        }
        return $ret;
    }

    /**
     * Get Cart array
     * @return Array
     */
    public function getArray() {
        return $this->items;
    }

    /**
     * Add new Product to Cart
     * @param mixed $productId
     * @param integer $qty (default = 1)
     * @return boolean
     */
    public function addItem($productId, $qty = 1) {
        $key = $this->getKey($productId);
        if ($key < 0) {
            array_push($this->items, (object) array(
                        'productId' => $productId,
                        'qty' => $qty
            ));
        } else {
            $this->items[$key]->qty += $qty;
        }
        return true;
    }

    /**
     * Update quantity for Product by ID
     * @param mixed $productId
     * @param integer $qty
     * @return boolean
     */
    public function updateQty($productId, $qty) {
        $key = $this->getKey($productId);
        if ($key >= 0) {
            $this->items[$key]->qty = $qty;
            return true;
        }

        return false;
    }

    /**
     * Remove product from Cart by Product ID
     * @param mixed $productId
     * @return boolean
     */
    public function removeItem($productId) {
        $key = $this->getKey($productId);
        if ($key >= 0) {
            unset($this->items[$key]);
            return true;
        }

        return false;
    }

    /**
     * Get count of all products in Cart
     * @return integer
     */
    public function getCount() {
        $count = 0;
        foreach ($this->items as $key => $product) {
            $count += $product->qty;
        }
        return $count;
    }

}
