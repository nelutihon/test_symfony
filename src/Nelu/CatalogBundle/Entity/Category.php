<?php

namespace Nelu\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Nelu\CatalogBundle\Entity\CategoryRepository")
 * @UniqueEntity(fields={"category"}, message="entity with this name already exists")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Category {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, unique=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Nelu\CatalogBundle\Entity\Product", mappedBy="category", cascade="remove")
     */
    private $products;

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
     * @param string $category
     * @return Category
     */
    public function setCategory( $category ) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Category
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
        return (string) $this->getCategory();
    }

}
