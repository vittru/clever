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
    public $url;
    public $supercats;
    public $hidden;
    
    function __construct($id, $name, $description, $shortdesc, $howTo, $madeOf, $sale, $firmId, $problem, $bestbefore, $precaution, $url, $hidden) {
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
       $this->url = $url;
       $this->hidden = $hidden;
    }
    
    function getFirstAvailSize() {
        foreach($this->sizes as $size) {
            if ($size->isAvailable()) {
                return $size->id;
            }
        }    
        return 0;         
    }    
    
    function getMinSizePrice() {
        foreach($this->sizes as $size) {
            //if ($size->isAvailable())
                return $size->price;
        }    
        return 0;        
    }    
    
    function getPrice() {  
        return ceil($this->getMinSizePrice() * (100-$this->sale)/100);
    }
    
    function getWebPrice() {
        $price = $this->getPrice();
        if ($price > 0) {
            return $price . currency;
        } else {
            return "";
        }
    }
    
    function getWebOldPrice() {
        return $this->getMinSizePrice() . currency;
    }
    
    function isAvailable() {
        $total = 0;
        foreach ($this->sizes as $size) {
            $total = $total + $size->instock - $size->onhold;
        }
        return ($total > 0);
    }
    
    function showInCatalog($bb, $row = null) {
        if (!isset($bb)) {
            $bb = false;
        };
        if (!isset ($row)) {
            $row=4;
        };
        if (!$this->hidden) {
            echo '<li class="col-sm-'.$row.' good">';
            foreach ($this->types as $id=>$type) {
                echo '<div hidden class="type_'. $id . '"></div>';
            }
            foreach ($this->problems as $problem) {
                echo '<div hidden class="problem_' . $problem . '"></div>';
            }
            foreach ($this->effs as $effect) {
                echo '<div hidden class="effect_' . $effect . '"></div>';
            }
            foreach ($this->supercats as $id => $supercat) {
                if ($id) {
                    echo '<div hidden class="supercat_' . $id . '"></div>';
                }
            }
            foreach ($this->skintypes as $skintype) {
                if ($id) {
                    echo '<div hidden class="skintype_' . $skintype . '"></div>';
                }
            }
            foreach ($this->hairtypes as $hairtype) {
                if ($id) {
                    echo '<div hidden class="hairtype_' . $hairtype . '"></div>';
                }
            }
            echo '<div hidden class="firm_' . $this->firmId . '"></div>';
            echo '<figure>';
            echo '<a class="aa-product-img" data-toggle2="tooltip" data-placement="top" data-target="#single-product" href="/showgood?id=';
            echo $this->id;
            if ($bb) {
                echo '&bb';
            }
            echo '"><img src="';
            echo $this->getImage();
            echo '" alt="';
            echo str_replace('"', "'", $this->name);
            echo '" title="';
            echo str_replace('"', "'", $this->name);
            echo'"></a>';
            /*if ($bb or $this->isAvailable()) {
                echo '<a class="aa-action-btn aa-add-card-btn orange-button" id="';
                echo $this->id;
                echo '" value="';
                echo $this->getFirstAvailSize();
                echo '" data-price="';
                if ($bb) {
                    echo $this->getBBPrice();
                } else {
                    echo $this->getPrice();
                }
                echo '" data-sale="';
                if ($bb or $this->sale) {
                    echo "1";
                } else {
                    echo "0";
                }
                echo '"><span class="fa fa-shopping-cart"></span>В корзину</a>';
            } else {
                echo '<a class="aa-action-btn aa-emailme-btn green-button" id="emailMeBtn';
                echo '"><span class="fa fa-envelope"></span>Заказать</a>';
            }*/
            echo '<figcaption>';
            echo '<div class="aa-product-title"><a href="/showgood?id=';
            echo $this->id;
            if ($bb) {
                echo '&bb';
            }            
            echo '" data-toggle2="tooltip" data-placement="top" data-target="#single-product">';
            echo $this->name;
            echo '</a></div>';
            echo '<span class="aa-product-price" value=';
            if ($bb) {
                echo $this->getBBPrice();
            } else {
                echo $this->getPrice();
            }
            echo '>';
            if ($bb) {
                echo $this->getWebBBPrice();
            } else {
                echo $this->getWebPrice();
            }
            echo '</span>';
            if ($this->isAvailable() && $this->sale > 0 && !$bb) {
                echo '<span class="aa-product-price"><del>';
                echo $this->getWebOldPrice();
                echo '</del></span>';
            }
            if ($bb && $this->getPrice() > $this->getBBPrice()) {
                echo '<span class="aa-product-price"><del>';
                echo $this->getWebPrice();
                echo '</del></span>';            }
            echo '<div class="aa-product-title">';
            if ($bb or $this->isAvailable()) {
                echo '<div class="green-button good-button aa-add-card-btn" id="';
                echo $this->id;
                echo '" value="';
                echo $this->getFirstAvailSize();
                echo '" data-price="';
                if ($bb) {
                    echo $this->getBBPrice();
                } else {
                    echo $this->getPrice();
                }
                echo '" data-sale="';
                if ($bb or $this->sale) {
                    echo "1";
                } else {
                    echo "0";
                }
                
                echo '"><span class="fa fa-shopping-cart"></span>В корзину</div>';
                //echo '<div class="green-button good-button aa-quick-order-btn" data-toggle="modal" data-target="#quickOrder"><span class="fa fa-bolt"></span>Купить в 1 клик</div>';
            } else {
                echo '<div class="aa-emailme-btn green-button good-button" id="emailMeBtn';
                echo '"><span class="fa fa-envelope"></span>Заказать</div>';
            }    
            echo '</div>';
            echo '</figcaption>';
            echo '</figure>';
            //echo '<div class="aa-product-hvr-content">';
            //echo '<a href="#" data-toggle="tooltip" data-placement="top" title="В корзину"><span class="fa fa-shopping-cart"></span></a>';
            //echo '<a href="#" data-toggle="tooltip" data-placement="top" title="Купить в 1 клик"><span class="fa fa-bolt"></span></a>';
            //echo '<a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#single-product"><span class="fa fa-search"></span></a>'                          
            //echo '</div>';
            if ($this->sale > 0 && !$bb) {
                echo '<span class="aa-badge aa-sale">Скидка!</span> ';
            }
            if (!$bb and !$this->isAvailable()) {
                echo '<span class="aa-badge aa-sold-out">Под заказ</span>';
            }
            echo '</li>';
        }    
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
            return $this->getWebProperty('<b>Срок и условия хранения: </b>' . $this->bestbefore);
        } else {
            return '';
        }
    }

    function getWebPrecaution() {
        if ($this->precaution) {
            return $this->getWebProperty('<b>Противопоказания: </b>' . $this->precaution);
        } else {
            return '';
        }
    }    
    
    function getWebSkinTypes() {
        if ($this->hasSkintypes()) {
            return '<p><b>Типы кожи: </b>';
        } else {
            return '';
        }
    }

    function getWebHairTypes() {
        if ($this->hasHairtypes()) {
            return '<p><b>Типы волос: </b></p>';
        } else {
            return '';
        }
    }

    function hasBB() {
        $bb = false;
        foreach ($this->sizes as $id=>$size) {
            if ($size->isBB()) {
                $bb = true;
            }
        }
        return $bb;
    }
    
    function getBBPrice() {
        if ($this->hasBB()) {
            foreach ($this->sizes as $id => $size) {
                if ($size->isBB()) {
                    return $size->bbprice;
                }
            }
        } else {
            return null;
        }
    }

    function getWebBBPrice() {
        if ($this->hasBB()) {
            foreach ($this->sizes as $id => $size) {
                if ($size->isBB()) {
                    return $size->getWebBBPrice();
                }
            }
        } else {
            return null;
        }
    }
}