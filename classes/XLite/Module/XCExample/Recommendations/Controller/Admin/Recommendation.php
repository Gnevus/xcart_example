<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\Controller\Admin;

/**
 * Recommendation modify controller
 */
class Recommendation extends \XLite\Controller\Admin\AAdmin
{
    public function checkACL()
    {
        return parent::checkACL();
    }

    /**
     * Return recommendation id from request
     *
     * @return integer
     */
    public function getId()
    {
        return (int)\XLite\Core\Request::getInstance()->id;
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->getRecommendation() && $this->getRecommendation()->isPersistent()) {
            $label = 'Edit recommendation';
        } else {
            $label = 'Add recommendation';
        }

        return static::t($label);
    }

    /**
     * Return target product Id
     *
     * @return integer
     */
    public function getRequestTargetProductId()
    {
        return (int)\XLite\Core\Request::getInstance()->target_product_id;
    }

    /**
     * Alias
     *
     * @return \XLite\Module\XCExample\Recommendations\Model\Recommendation
     */
    public function getRecommendation()
    {
        $result = \XLite\Core\Database::getRepo('\XLite\Module\XCExample\Recommendations\Model\Recommendation')->find($this->getId());

        return $result ? : new \XLite\Module\XCExample\Recommendations\Model\Recommendation();
    }

    /**
     * Return current product
     *
     * @return \XLite\Model\Product
     */
    public function getProduct()
    {
        return ($this->getRecommendation())
            ? $this->getRecommendation()->getProduct()
            : null;
    }

    /**
     * Return current product Id
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->getProduct()
            ? $this->getProduct()->getProductId()
            : null;
    }

    /**
     * Set return URL
     *
     * @param string $url Url OPTIONAL
     *
     * @return void
     */
    public function setReturnURL($url = '')
    {
        $targetProductId = $this->getRequestTargetProductId();

        $url = $targetProductId
            ? \XLite\Core\Converter::buildURL(
                'product',
                '',
                ['product_id' => $targetProductId, 'page' => 'product_recommendations']
            )
            : \XLite\Core\Converter::buildURL('recommendations');

        parent::setReturnURL($url);
    }

    /**
     * Modify model
     *
     * @return void
     */
    protected function doActionModify()
    {
        $this->getModelForm()->performAction('modify');
        $this->setReturnURL();
        $this->setHardRedirect();
    }

    /**
     * doActionDelete
     *
     * @return void
     */
    protected function doActionDelete()
    {
        $recommendation = $this->getRecommendation();

        if (isset($recommendation)) {
            \XLite\Core\Database::getEM()->remove($recommendation);
            \XLite\Core\Database::getEM()->flush();

            \XLite\Core\TopMessage::addInfo(
                static::t('Recommendation has been deleted')
            );

            $this->setReturnURL();
            $this->setHardRedirect();
        }
    }

    /**
     * Get model form class
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XCExample\Recommendations\View\Model\Recommendation';
    }
}
