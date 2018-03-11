<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 05/03/2018
 * Time: 23:50
 */

namespace App\Models;


class HashMap
{
    private $value;

    /**
     * HashMap constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = (is_array($value)) ? $value : array($value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    public function length(){
        return count($this->value);
    }
    public function has($find){
        $exists = FALSE;
        if(!is_array($this->value)){
            return;
        }
        foreach ($this->value as $key => $value) {
            if($find == $value){
                $exists = TRUE;
            }
        }
        return $exists;
    }
    public function hasLike($find){
        $exists = FALSE;
        if(!is_array($this->value)){
            return;
        }
        foreach ($this->value as $key => $value) {
            if(strtolower($find) == strtolower($value)){
                $exists = TRUE;
            }
        }
        return $exists;
    }
}