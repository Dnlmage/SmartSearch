<?php
namespace DanilLozenko\SmartSearch\Model\Indexer;

use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use \Magento\Catalog\Helper\Image;
use Magento\Framework\App\ResourceConnection;
use Magento\CatalogRule\Model\Indexer\IndexerTableSwapperInterface as TableSwapper;
use \Magento\Catalog\Model\CategoryFactory;

/**
 * Class Fulltext
 * @package DanilLozenko\SmartSearch\Model\Indexer
 */
class Fulltext implements \Magento\Framework\Indexer\ActionInterface
{

    const INDEXER_ID = 'DanilLozenko_smartsearch_indexer';

    /**
     * @var array
     */
    private $data;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var Image
     */
    private $imageHelper;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var TableSwapper
     */
    private $tableSwapper;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * Fulltext constructor.
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Image $imageHelper
     * @param ResourceConnection $resource
     * @param TableSwapper $tableSwapper
     * @param CategoryFactory $categoryFactory,
     * @param array $data
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        Image $imageHelper,
        ResourceConnection $resource,
        TableSwapper $tableSwapper,
        CategoryFactory $categoryFactory,
        array $data
    ) {
        $this->data = $data;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        $this->resource = $resource;
        $this->tableSwapper = $tableSwapper;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @return bool
     */
    public function executeFull()
    {
        $connection = $this->resource->getConnection();
        $productCollection = $this->productCollectionFactory->create();
        $productCollection = $productCollection->addAttributeToSelect('*')
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('visibility', 4)
            ->load();
        $dataToInsert = [];

        foreach ($productCollection as $key => $product){
            $categoryPath = '';
            $imageUrl = $this->imageHelper->init($product, 'product_page_image_small')
                ->setImageFile($product->getSmallImage())
                ->resize(380)
                ->getUrl();
            if(!empty($product->getCategoryIds())){
                $categoryPath = $this->categoryFactory->create()->load($product->getCategoryIds()[0])->getPath();
            }
            $dataToInsert[] = ['name' => $product->getName(),
                'image' => $imageUrl,
                'category_id' => $categoryPath,
                'store_id' => implode('/', $product->getStoreIds()),
                'sku' => $product->getSku()
            ];
        }

        $indexTable = $this->resource->getTableName(
            $this->tableSwapper->getWorkingTableName('DanilLozenko_smart_search_index')
        );

        $connection->insertMultiple($indexTable, $dataToInsert);

        $this->tableSwapper->swapIndexTables(
            [
                'DanilLozenko_smart_search_index'
            ]
        );

        return true;
    }

    public function executeList(array $ids)
    {
        $this->execute($ids);
    }

    public function executeRow($id)
    {
        $this->execute([$id]);
    }

}
