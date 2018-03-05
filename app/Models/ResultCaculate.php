<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 01/03/2018
 * Time: 21:13
 */

namespace App\Models;


class ResultCaculate
{
    private $status;
    private $msg;
    private $data;
    private $issueHightlightIndex;

    /**
     * ResultCaculate constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIssueHightlightIndex()
    {
        return $this->issueHightlightIndex;
    }

    /**
     * @param mixed $issueHightlightIndex
     */
    public function setIssueHightlightIndex($issueHightlightIndex)
    {
        $this->issueHightlightIndex = $issueHightlightIndex;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }



}