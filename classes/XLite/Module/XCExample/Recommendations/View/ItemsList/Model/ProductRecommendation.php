<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\View\ItemsList\Model;

/**
 * Recommendations list for tab in product details page
 *
 */
class ProductRecommendation extends \XLite\Module\XCExample\Recommendations\View\ItemsList\Model\Recommendation
{
    /**
     * Widget param names
     */
    const PARAM_PRODUCT_ID = 'product_id';

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), ['product']);
    }

    /**
     * Should itemsList be wrapped with form
     *
     * @return boolean
     */
    protected function wrapWithFormByDefault()
    {
        return true;
    }

    /**
     * Get search panel widget class
     *
     * @return string
     */
    protected function getSearchPanelClass()
    {
        return null;
    }

    /**
     * Get wrapper form target
     *
     * @return array
     */
    protected function getFormTarget()
    {
        return 'recommendations';
    }

    /**
     * Get wrapper form params
     *
     * @return array
     */
    protected function getFormParams()
    {
        $params = [];

        $productId = \XLite\Core\Request::getInstance()->product_id;
        if ($productId) {
            $params['product_id'] = $productId;
        }

        return array_merge(
            parent::getFormParams(),
            $params
        );
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $allowedColumns = [
            'text',
            'url',
        ];

        $columns = parent::defineColumns();

        // Remove redundant columns
        foreach ($columns as $k => $v) {
            if (!in_array($k, $allowedColumns)) {
                unset($columns[$k]);
            }
        }

        return $columns;
    }

    /**
     * Get create entity URL
     *
     * @return string
     */
    protected function getCreateURL()
    {
        return \XLite\Core\Converter::buildURL('recommendation');
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        $productId = $this->getProductId();

        $result->{\XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_PRODUCT}
            = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($productId);

        return $result;
    }

    /**
     * Get AJAX-specific URL parameters
     *
     * @return array
     */
    protected function getAJAXSpecificParams()
    {
        $params = parent::getAJAXSpecificParams();
        $params[static::PARAM_PRODUCT_ID] = $this->getProductId();

        return $params;
    }

    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Entity
     *
     * @return boolean
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::isClassColumnVisible($column, $entity);

        return $result;
    }
}
