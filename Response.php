<?php

namespace fall1600\Package\Newebpay;

class Response
{
    /** @var array */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 回傳狀態
     *   成功: SUCCESS
     *   失敗: 錯誤代碼
     * @return string
     */
    public function getStatus()
    {
        return $this->data['Status'];
    }

    /**
     * 回傳訊息
     * @return string
     */
    public function getMessage()
    {
        return $this->data['Message'];
    }

    /**
     * 回傳參數細節
     * @return array
     */
    public function getResult()
    {
        return $this->data['Result'];
    }
}
