<?php
namespace DanilLozenko\SmartSearch\Model\ResourceModel\SmartSearchIndex;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \DanilLozenko\SmartSearch\Model\SmartSearchIndex::class,
            \DanilLozenko\SmartSearch\Model\ResourceModel\SmartSearchIndex::class
        );
    }
}
