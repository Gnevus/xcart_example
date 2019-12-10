<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\Model\Repo;

/**
 * @Api\Operation\Create(modelClass="XLite\Module\XCExample\Recommendations\Model\Recommendation", summary="Add product recommendation")
 * @Api\Operation\Read(modelClass="XLite\Module\XCExample\Recommendations\Model\Recommendation", summary="Retrieve product recommendation by id")
 * @Api\Operation\ReadAll(modelClass="XLite\Module\XCExample\Recommendations\Model\Recommendation", summary="Retrieve product recommendations by conditions")
 * @Api\Operation\Update(modelClass="XLite\Module\XCExample\Recommendations\Model\Recommendation", summary="Update product recommendation by id")
 * @Api\Operation\Delete(modelClass="XLite\Module\XCExample\Recommendations\Model\Recommendation", summary="Delete product recommendation by id")
 *
 * @SWG\Tag(
 *   name="XCExample\Recommendations\Recommendation",
 *   x={"display-name": "Recommendation", "group": "XCExample\Recommendations"},
 *   description="This repo stores customer feedback - product recommendation records.",
 * )
 */
class Recommendation extends \XLite\Model\Repo\ARepo
{
    // {{{ Search

    /**
     * Additional search modes
     */
    const SEARCH_TYPE_REVIEWS_ONLY = 100;
    const SEARCH_ADDITION_DATE = 'additionDate';
    const SEARCH_STATUS = 'status';
    const SEARCH_PRODUCT = 'product';
    const SEARCH_KEYWORDS = 'keywords';
    const SEARCH_RATING = 'rating';
    const SEARCH_DATE_RANGE = 'dateRange';
    const SEARCH_TYPE = 'type';

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndProduct(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        if ($value instanceof \XLite\Model\Product) {
            $queryBuilder->linkInner('r.product', 'p');

            $queryBuilder->andWhere('p.product_id = :productId')
                ->setParameter('productId', $value->getProductId());
        }
    }
}
