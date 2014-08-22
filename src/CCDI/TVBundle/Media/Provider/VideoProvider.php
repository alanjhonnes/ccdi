<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 8/20/14
 * Time: 2:34 PM
 */

namespace CCDI\TVBundle\Media\Provider;


use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\BaseProvider;
use Sonata\MediaBundle\Provider\BaseVideoProvider;
use Sonata\MediaBundle\Provider\FileProvider;
use Symfony\Component\Form\FormBuilder;

class VideoProvider extends BaseVideoProvider {
    /**
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     *
     * @return void
     */
    protected function doTransform(MediaInterface $media)
    {
        // TODO: Implement doTransform() method.
    }

    public function getHelperProperties(MediaInterface $media, $format)
    {
        // TODO: Implement getHelperProperties() method.
    }

    public function getDownloadResponse(MediaInterface $media, $format, $mode, array $headers = array())
    {
        // TODO: Implement getDownloadResponse() method.
    }

    public function updateMetadata(MediaInterface $media, $force = false)
    {
        // TODO: Implement updateMetadata() method.
    }


} 