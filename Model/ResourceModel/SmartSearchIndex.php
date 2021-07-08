<?php
namespace DanilLozenko\SmartSearch\Model\ResourceModel;

class SmartSearchIndex extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DanilLozenko_smart_search_index', 'id');
    }
}
