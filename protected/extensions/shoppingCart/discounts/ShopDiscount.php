<?php

class ShopDiscount extends IEDiscount
{
    public function apply()
    {
        $userDiscount = 0;

        $user = Users::model()->findByPk(Yii::app()->user->id);
        if( !is_null($user) )
        {
            $userDiscount = $user->discount;
        }
        
        foreach($this->shoppingCart as $position)
        {
            if( $userDiscount > 0 )
            {
                $discountPrice = $userDiscount * $position->getPrice() / 100 * $position->getQuantity();
                $position->addDiscountPrice($discountPrice);
            }
        }
    }
}

?>