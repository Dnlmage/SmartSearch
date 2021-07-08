<?php
namespace DanilLozenko\SmartSearch\Model;

use \DanilLozenko\SmartSearch\Api\SmartSearchRepositoryInterface;
use \Magento\Framework\App\ResourceConnection;
use \DanilLozenko\SmartSearch\Helper\Search\Config;
use \Magento\Store\Model\StoreManagerInterface;

class SmartSearchRepository implements SmartSearchRepositoryInterface
{

    protected $resource;

    protected $storeManager;

    protected $config;

    public function __construct(
        ResourceConnection $resource,
        StoreManagerInterface $storeManager,
        Config $config
    ) {
        $this->resource = $resource;
        $this->storeManager = $storeManager;
        $this->config = $config;
    }


    public function getDataForSearch($serachText, $serachCategory)
    {
        $connection = $this->resource->getConnection();
        $select = $connection->select()->from('DanilLozenko_smart_search_index')
            ->where("name like '%{$serachText}%'")
            ->where(
                new \Zend_Db_Expr("CONCAT('/', store_id, '/') like '%/" . $this->storeManager->getStore()->getId() . "/%'")
            )->limit($this->config->getLimit());

        if($serachCategory !== '0'){
            $select->where(
                new \Zend_Db_Expr("CONCAT('/', category_id, '/') like '%/" . $serachCategory . "/%'")
            );
        }

        return $connection->fetchAll($select);
    }

}
