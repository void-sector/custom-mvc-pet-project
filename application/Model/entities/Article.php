<?php

namespace Model\entities;

/**
 * @Entity(repositoryClass="ArticleRepository")
 * @Entity @Table(name="articles")
 **/
class Article
{
    /**
     * @id @Column(type="integer") @GeneratedValue
     * @var int
     */
    public $id;


    /**
     * @Column(type="string")
     * @var string
     */
    public $slug;


    /**
     * @Column(type="string")
     * @var string
     */
    public $image;


    /**
     * @Column(type="string")
     * @var string
     */
    public $thumbnail;


    /**
     * @Column(type="string")
     * @var string
     */
    public $intro;


    /**
     * @Column(type="string")
     * @var string
     */
    public $title;


    /**
     * @Column(type="string")
     * @var string
     */
    public $content;



    /**
     * @Column(type="string")
     * @var string
     */
    public $created;

    /**
     * @Column(type="string")
     * @var string
     */
    public $published;


    /**
     * @Column(type="integer")
     * @var int
     */
    public $views;

    /**
     * Get Id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    
    public function getIntro()
    {
        return $this->intro;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function getSlug()
    {
        return $this->slug;
    }


    public function hasImage()
    {
        return (bool) (null !== $this->image);
    }


    public function getImage()
    {
        return $this->image;
    }


    public function hasThumbnail()
    {
        return (bool) (null !== $this->thumbnail);
    }


    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function getPublished()
    {
        return $this->published;
    }
}