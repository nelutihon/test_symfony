<?php

namespace Nelu\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Nelu\CatalogBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer")
     */

    /**
     * @ORM\ManyToOne(targetEntity="Category", cascade={"remove"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $productName;

    /**
     * @var float
     *
     * @ORM\Column(name="product_price", type="float")
     */
    private $productPrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param integer $category
     * @return Product
     */
    public function setCategory( Category $category ) {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return integer 
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set productName
     *
     * @param string $productName
     * @return Product
     */
    public function setProductName( $productName ) {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string 
     */
    public function getProductName() {
        return $this->productName;
    }

    /**
     * Set productPrice
     *
     * @param float $productPrice
     * @return Product
     */
    public function setProductPrice( $productPrice ) {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return float 
     */
    public function getProductPrice() {
        return $this->productPrice;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt( $updatedAt ) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updated_at() {
        $this->setUpdatedAt( new \DateTime( 'now' ) );
    }
    
    public function __toString() {
        return (string) $this->getProductName();
    }

}
