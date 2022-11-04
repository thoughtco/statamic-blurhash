<?php

namespace Thoughtco\BlurHash\Tags;

use Bepsvpt\Blurhash\Facades\BlurHash as BlurHashFacade;
use Statamic\Contracts\Assets\Asset as AssetContract;
use Statamic\Tags\Concerns\RendersAttributes;
use Statamic\Tags\Tags;

class BlurHash extends Tags
{
    use RendersAttributes;

    /**
     * The {{ blur_hash:encode }} tag.
     *
     * @return string|array
     */
    public function encode()
    {
        $image = $this->params->get('image');
        
        if ($image instanceof AssetContract) {
            $image = $image->contents();
        }
                                
        return BlurHashFacade::encode($image);
    }

    /**
     * The {{ blur_hash:decode }} tag.
     *
     * @return string|array
     */
    public function decode($encodedString = null)
    {
        if (! $encodedString) {
            $encodedString = $this->params->get('hash');
        }
        
        $width = $this->params->get('width', 64);
        $height = $this->params->get('height', 64);

        $image = BlurHashFacade::decode($encodedString, $width, $height);
            
        return $image->encode($this->params->get('format', 'data-url'));
    }
    
    /**
     * The {{ blur_hash }} tag.
     * Encodes and outputs an image
     *
     * @return string|array
     */
    public function index()
    {
        $image = $this->params->get('image');
        
        return '<img src="'.$this->decode($this->encode($image)).'" '.$this->renderAttributesFromParams(['image']).' />';
    } 

    /**
     * The {{ blur_hash:* }} tag.
     *
     * @return string|array
     */    
    public function wildcard($tag)
    {
        $this->params->set('image', $tag);
        
        return $this->index();
    }   
}