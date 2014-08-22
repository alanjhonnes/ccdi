<?php

namespace CCDI\CoreBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Alan Jhonnes <aj@alanjhonnes.com>
 * @ORM\Entity(repositoryClass="CCDI\CoreBundle\Entity\PostRepository")
 * @ORM\Table(name="post")
 */
class Post {
     
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $officeOnly;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;
    
    
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set officeOnly
     *
     * @param boolean $officeOnly
     * @return Post
     */
    public function setOfficeOnly($officeOnly)
    {
        $this->officeOnly = $officeOnly;

        return $this;
    }

    /**
     * Get officeOnly
     *
     * @return boolean 
     */
    public function getOfficeOnly()
    {
        return $this->officeOnly;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return Post
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
}
