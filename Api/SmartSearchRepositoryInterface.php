<?php
namespace DanilLozenko\SmartSearch\Api;

interface SmartSearchRepositoryInterface
{
    /**
     * @param string $serachText
     * @param int $serachCategory
     * @return array
     */
    public function getDataForSearch($serachText, $serachCategory);
}
