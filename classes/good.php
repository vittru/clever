<?php


Class Good {
    
    public $id; 
    public $name;
    public $description;
    public $shortdesc;
    public $howTo;
    public $madeOf;
    public $sale;
    public $firmId;
    public $cats;
    public $problem;
    public $effs;
    public $skintypes;
    public $hairtypes;
    public $sizes;
    public $types;
   
    function __construct($id, $name, $description, $shortdesc, $howTo, $madeOf, $sale, $firmId, $problem) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->shortdesc = $shortdesc;
       $this->howTo = $howTo;
       $this->madeOf = $madeOf;
       $this->sale = $sale;
       $this->firmId = $firmId;
       $this->problem = $problem;
    }
    
    function getWebPrice() {
        $price = reset($this->sizes)->price * (100-$this->sale)/100;
        if ($price > 0)
            return $price . " руб.";
        else
            return "";
    }
    
    function getWebOldPrice() {
        return reset($this->sizes)->price . " руб.";
    }
    
    function isAvailable() {
        $total = 0;
        foreach ($this->sizes as $size) {
            $total = $total + $size->instock - $size->onhold;
        }
        return ($total > 0);
    }
    
    function showInCatalog() {
        echo '<li class="col-sm-3">';
        echo '<figure>';
        echo '<a class="aa-product-img" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#quick-view-modal" href="/showgood?id=';
        echo $this->id;
        echo '"><img src="';
        echo $this->getImage();
        echo '" alt="';
        echo $this->name;
        echo'"></a>';
        if ($this->isAvailable()) {
            echo '<a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>В корзину</a>';
        }
        echo '<figcaption>';
        echo '<h4 class="aa-product-title"><a href="/showgood?id=';
        echo $this->id;
        echo '" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#quick-view-modal">';
        echo $this->name;
        echo '</a></h4>';
        echo '<span class="aa-product-price">';
        echo $this->getWebPrice();
        echo '</span>';
        if ($this->sale > 0) {
            echo '<span class="aa-product-price"><del>';
            echo $this->getWebOldPrice();
            echo '</del></span>';
        }
        echo '</figcaption>';
        echo '</figure>';
        //<!-- div class="aa-product-hvr-content">
        //    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
        //    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
        //    <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>                          
        //</div -->
        if ($this->sale > 0) {
            echo '<span class="aa-badge aa-sale">Скидка!</span> ';
        }
        if (!$this->isAvailable()) {
            echo '<span class="aa-badge aa-sold-out">Нет в наличии</span>';
        }
        echo '</li>';
    }
    
    function getImage() {
        $file_name = 'images/goods/good' . $this->id . '-1';
        if (!file_exists($file_name . '.jpg')) {
            if (!file_exists($file_name . '.png')) {
                $file_name = 'images/goods/good0.png';
            } else {
                $file_name = $file_name . '.png';
            }    
        } else {
            $file_name = $file_name . '.jpg';
        }
        return '/'.$file_name;
    }
    
    function hasEffects() {
        return sizeof($this->effs) > 0;
    }

    function hasSkintypes() {
        return sizeof($this->skintypes) > 0;
    }

    function hasHairtypes() {
        return sizeof($this->hairtypes) > 0;
    }
    
    function getWebProperty($property) {
        foreach (array("\r", "\n", "\r\n", "\n\r") as $token) {
            $property = str_replace($token, "</div><div>",  $property);
        }
        return "<div>" . $property . "</div>";
    }
    
    function getWebDescription() {
        return $this->getWebProperty($this->description);
    }
    
    function getWebHowTo() {
        return $this->getWebProperty($this->howTo);
    }
    
    function getWebMadeOf() {
        return $this->getWebProperty($this->madeOf);
    }
    
}

