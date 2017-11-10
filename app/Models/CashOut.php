<?php
/**
 * Created by PhpStorm.
 * User: dungnv31
 * Date: 11/10/2017
 * Time: 10:39 AM
 */

namespace App\Models;


class CashOut
{
    private $Id;
    private $PlayerId;
    private $ActionTypeId;
    private $Ratio;
    private $Description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getPlayerId()
    {
        return $this->PlayerId;
    }

    /**
     * @param mixed $PlayerId
     */
    public function setPlayerId($PlayerId)
    {
        $this->PlayerId = $PlayerId;
    }

    /**
     * @return mixed
     */
    public function getActionTypeId()
    {
        return $this->ActionTypeId;
    }

    /**
     * @param mixed $ActionTypeId
     */
    public function setActionTypeId($ActionTypeId)
    {
        $this->ActionTypeId = $ActionTypeId;
    }

    /**
     * @return mixed
     */
    public function getRatio()
    {
        return $this->Ratio;
    }

    /**
     * @param mixed $Ratio
     */
    public function setRatio($Ratio)
    {
        $this->Ratio = $Ratio;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param mixed $Description
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
    }

    /**
     * CashOut constructor.
     */
    public function __construct()
    {
    }
    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'PlayerId' => $this->PlayerId,
            'ActionTypeId' => $this->ActionTypeId,
            'Ratio' => $this->Ratio,
            'Description' => $this->Description
        ];
    }
}