<?php
/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\PageBundle\Entity;

use Sonata\PageBundle\Entity\BasePage as BasePage;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Page extends BasePage
{

    /**
     * @var integer $id
     */
    protected $id;
    
    protected $theme;
    
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }
    
    public function getTheme()
    {
        return $this->theme;
    }
    

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}