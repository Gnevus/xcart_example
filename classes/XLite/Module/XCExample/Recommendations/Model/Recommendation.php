<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\Model;

/**
 * @Entity
 * @Table (name="recommendations")
 */
class Recommendation extends \XLite\Model\AEntity
{
    /**
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $id;

    /**
     * @Column (type="text")
     */
    protected $text;

    /**
     * @Column (type="text")
     */
    protected $url;

    /**
     * @var boolean
     *
     * @Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * Relation to a product entity
     *
     * @var \XLite\Model\Product
     *
     * @ManyToOne  (targetEntity="XLite\Model\Product", inversedBy="recommendations")
     * @JoinColumn (name="product_id", referencedColumnName="product_id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * @return string
     */
    public function getURLForProductAdminPage()
    {
        return $this->getProduct()
            ? \XLite\Core\Converter::makeURLValid(
                \XLite\Core\Converter::buildFullURL('product', '', [
                    'product_id'    => $this->getProduct()->getProductId(),
                    'page'          => 'product_recommendations'
                ], \XLite::getAdminScript())
            )
            : '';
    }


    /**
     * Returns id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $value Value
     *
     * @return void
     */
    public function setText($value)
    {
        $this->text = $value;
    }

    /**
     * Returns text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set url
     *
     * @param string $value Value
     *
     * @return void
     */
    public function setUrl($value)
    {
        $this->url = $value;
    }

    /**
     * Returns url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Recommendation
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set product
     *
     * @param \XLite\Model\Product $product
     * @return Recommendation
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get product
     *
     * @return \XLite\Model\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

}
