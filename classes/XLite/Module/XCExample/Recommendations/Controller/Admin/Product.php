<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\Controller\Admin;

/**
 * Product modify controller
 */
class Product extends \XLite\Controller\Admin\Product implements \XLite\Base\IDecorator
{
    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        if (!$this->isNew()) {
            $list['product_recommendations'] = static::t('Product recommendations');
        }

        return $list;
    }

    /**
     * Handles the request
     *
     * @return void
     */
    public function handleRequest()
    {
        $cellName = \XLite\Module\XCExample\Recommendations\View\ItemsList\Model\Recommendation::getSessionCellName();
        \XLite\Core\Session::getInstance()->$cellName = [
            \XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_PRODUCT => $this->getProductId(),
        ];

        parent::handleRequest();
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();

        if (!$this->isNew()) {
            $list['product_recommendations'] = 'modules/XCExample/Recommendations/product/recommendations.twig';
        }

        return $list;
    }
}
