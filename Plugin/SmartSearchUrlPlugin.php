<?php
namespace DanilLozenko\SmartSearch\Plugin;

use \DanilLozenko\SmartSearch\Helper\Search\Data;
use DanilLozenko\SmartSearch\Helper\Search\Config;

/**
 * Class SmartSearchUrlPlugin
 * @package DanilLozenko\SmartSearch\Plugin
 */
class SmartSearchUrlPlugin
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Data
     */
    protected $data;

    /**
     * SmartSearchUrlPlugin constructor.
     * @param Data $data
     */
    public function __construct(
        Config $config,
        Data $data
    )
    {
        $this->config = $config;
        $this->data = $data;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed|string
     */
    public function afterGetSuggestUrl($subject, $result)
    {
        if($this->config->isEnabled()){
            return $this->data->getSuggestUrl();
        }
        return $result;
    }
}
