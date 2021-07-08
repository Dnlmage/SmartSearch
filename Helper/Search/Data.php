<?php
namespace DanilLozenko\SmartSearch\Helper\Search;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    /**
     * Construct
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Retrieve suggest url
     *
     * @return string
     */
    public function getSuggestUrl()
    {
        return $this->_getUrl(
            'smartsearch/ajax/suggest',
            ['_secure' => $this->_getRequest()->isSecure()]
        );
    }

}
