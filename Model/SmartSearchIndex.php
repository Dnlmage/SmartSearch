<?php
namespace DanilLozenko\SmartSearch\Model;

class SmartSearchIndex extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('DanilLozenko\SmartSearch\Model\ResourceModel\SmartSearchIndex');
    }

}
