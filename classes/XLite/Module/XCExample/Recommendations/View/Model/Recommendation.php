<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\View\Model;

/**
 * Recommendation view model
 */
class Recommendation extends \XLite\View\Model\AModel
{
    /**
     * @inheritdoc
     */
    public function __construct(array $params = [], array $sections = [])
    {
        $this->schemaDefault = [
            'product' => [
                self::SCHEMA_CLASS       => 'XLite\View\FormField\Select\Model\ProductSelector',
                self::SCHEMA_LABEL       => 'Product',
                self::SCHEMA_REQUIRED    => true,
            ],
            'text' => [
                self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
                self::SCHEMA_LABEL       => static::t('recommendation_text'),
                self::SCHEMA_REQUIRED    => true,
            ],
            'url' => [
                self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
                self::SCHEMA_LABEL       => static::t('recommendation_url'),
                self::SCHEMA_REQUIRED    => true,
            ],
        ];

        parent::__construct($params, $sections);

    }

    /**
     * Return current model ID
     *
     * @return integer
     */
    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->id;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Module\XCExample\Recommendations\Model\Recommendation
     */
    protected function getDefaultModelObject()
    {
        $model = \XLite\Core\Database::getRepo('XLite\Module\XCExample\Recommendations\Model\Recommendation')->find($this->getModelId());

        return $model ?: new \XLite\Module\XCExample\Recommendations\Model\Recommendation;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\Module\XCExample\Recommendations\View\Form\Model\Recommendation';
    }

    public function isValid()
    {
        return parent::isValid() && $this->getModelObject()->getProduct();
    }
}
