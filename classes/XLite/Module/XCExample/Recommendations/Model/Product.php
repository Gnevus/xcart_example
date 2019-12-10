<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\Model;

/**
 * Product
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * Product recommendations
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Module\XCExample\Recommendations\Model\Recommendation", mappedBy="product", cascade={"all"})
     * @OrderBy   ({"text" = "DESC"})
     */
    protected $recommendations;

    /**
     * Add recommendations
     *
     * @param \XLite\Module\XCExample\Recommendations\Model\Recommendation $recommendations
     * @return Product
     */
    public function addRecommendations(\XLite\Module\XCExample\Recommendations\Model\Recommendation $recommendations)
    {
        $this->recommendations[] = $recommendations;

        return $this;
    }

    /**
     * Get recommendations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }
}
