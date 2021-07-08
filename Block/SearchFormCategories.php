<?php
namespace DanilLozenko\SmartSearch\Block;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Catalog\Helper\Category;

/**
 * Class SearchFormCategories
 * @package DanilLozenko\SmartSearch\Block
 */
class SearchFormCategories extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Helper\Category
     */
    public $categoryHelper;

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        Category $categoryHelper,
        array $data = []
    )
    {
        $this->categoryHelper = $categoryHelper;
        parent::__construct($context, $data);
    }

    /**
     * @param boolean $sorted
     * @param boolean $asCollection
     * @param boolean $toLoad
     * @return array|\Magento\Framework\Data\Tree\Node\Collection
     */
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }

}
