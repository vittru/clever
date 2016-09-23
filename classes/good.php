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
    public $problems;
    public $bestbefore;
    public $precaution;
    
    function __construct($id, $name, $description, $shortdesc, $howTo, $madeOf, $sale, $firmId, $problem, $bestbefore, $precaution) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->shortdesc = $shortdesc;
       $this->howTo = $howTo;
       $this->madeOf = $madeOf;
       $this->sale = $sale;
       $this->firmId = $firmId;
       $this->problem = $problem;
       $this->bestbefore = $bestbefore;
       $this->precaution = $precaution;
    }
    
    function getFirstAvailSize() {
        foreach($this->sizes as $size) {
            if ($size->isAvailable())
                return $size->id;
        }    
        return 0;         
    }    
    
    function getMinSizePrice() {
        foreach($this->sizes as $size) {
            if ($size->isAvailable())
                return $size->price;
        }    
        return 0;        
    }    
    
    function getPrice() {  
        return $this->getMinSizePrice() * (100-$this->sale)/100;
    }
    
    function getWebPrice() {
        $price = $this->getPrice();
        if ($price > 0)
            return $price . " руб.";
        else
            return "";
    }
    
    function getWebOldPrice() {
        return $this->getMinSizePrice() . " руб.";
    }
    
    function isAvailable() {
        $total = 0;
        foreach ($this->sizes as $size) {
            $total = $total + $size->instock - $size->onhold;
        }
        return ($total > 0);
    }
    
    function showInCatalog() {
        echo '<li class="col-sm-3 good">';
        echo '<figure>';
        echo '<a class="aa-product-img" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#single-product" href="/showgood?pm&id=';
        echo $this->id;
        echo '"><img src="';
        echo $this->getImage();
        echo '" alt="';
        echo $this->name;
        echo'"></a>';
        if ($this->isAvailable()) {
            echo '<a class="aa-add-card-btn" id="';
            echo $this->id;
            echo '" value="';
            echo $this->getFirstAvailSize();
            echo '"><span class="fa fa-shopping-cart"></span>В корзину</a>';
        }
        echo '<figcaption>';
        echo '<h4 class="aa-product-title"><a href="/showgood?pm&id=';
        echo $this->id;
        echo '" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#single-product">';
        echo $this->name;
        echo '</a></h4>';
        echo '<span class="aa-product-price" value=';
        echo $this->getPrice();
        echo '>';
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
        //    <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#single-product"><span class="fa fa-search"></span></a>                          
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
    
    function getSecondImage() {
        $file_name = 'images/goods/good' . $this->id . '-2';
        if (!file_exists($file_name . '.jpg')) {
            if (!file_exists($file_name . '.png')) {
                return '';
            } else {
                $file_name = $file_name . '.png';
            }    
        } else {
            $file_name = $file_name . '.jpg';
        }
        return '/'.$file_name;        
    }
    
    function getThirdImage() {
        $file_name = 'images/goods/good' . $this->id . '-3';
        if (!file_exists($file_name . '.jpg')) {
            if (!file_exists($file_name . '.png')) {
                return '';
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

    function hasProblems() {
        return sizeof($this->problems) > 0;
    }
    
    function hasSkintypes() {
        return sizeof($this->skintypes) > 0;
    }

    function hasHairtypes() {
        return sizeof($this->hairtypes) > 0;
    }
    
    function getWebProperty($property) {
        foreach (array("\r", "\n", "\r\n", "\n\r") as $token) {
            $property = str_replace($token, "</p><p>",  $property);
        }
        return "<p>" . $property . "</p>";
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
    
    function getWebBestBefore() {
        if ($this->bestbefore) {
            return $this->getWebProperty('<b>Срок и условия хранения: </b>'.$this->bestbefore);
        }else
            return '';
    }

    function getWebPrecaution() {
        if ($this->precaution) 
            return $this->getWebProperty('<b>Противопоказания: </b>'.$this->precaution);
        else
            return '';
    }    
    
    function getWebSkinTypes() {
        if ($this->hasSkintypes()){
            return '<p><b>Типы кожи: </b>';
        } else return '';    
    }

    function getWebHairTypes() {
        if ($this->hasHairtypes()){
            return '<p><b>Типы волос: </b></p>';
        } else return '';    
    }    
}

