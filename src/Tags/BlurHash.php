<?php

namespace Thoughtco\BlurHash\Tags;

use Bepsvpt\Blurhash\Facades\BlurHash as BlurHashFacade;
use Statamic\Contracts\Assets\Asset as AssetContract;
use Statamic\Facades\Asset;
use Statamic\Tags\Concerns\RendersAttributes;
use Statamic\Tags\Tags;

class BlurHash extends Tags
{
    use RendersAttributes;

    private $dimensions = false;

    /**
     * The {{ blur_hash:encode }} tag.
     *
     * @return string|array
     */
    public function encode()
    {
        $image = $this->getImageFromParams();
        
        if ($image instanceof AssetContract) {
            $this->dimensions = $image->dimensions();

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
        $hash = $this->encode();

        if ($this->dimensions) {
            $width = $this->params->get('width', 0);
            $height = $this->params->get('height', 0);

            // If we have width but not height, we work out the height proportionally
            if ($width && ! $height) {
                $this->params->put('height', $width * $this->dimensions[1] / $this->dimensions[0]);

            // If we have height but not width, we work out the width proportionally
            } elseif ($height && ! $width) {
                $this->params->put('width', $height * $this->dimensions[0] / $this->dimensions[1]);
            }
        }

        return view('statamic-blurhash::output', [
            'src' => $this->decode($hash),
            'params' => $this->params,
            'render_params' => $this->renderAttributesFromParams(['image']),
        ]);
    }

    /**
     * The {{ blur_hash:* }} tag.
     *
     * @return string|array
     */
    public function wildcard($tag)
    {
        $this->params->put('image', $this->context->value($tag));

        return $this->index();
    }
    
    private function getImageFromParams()
    {
        if ($id = $this->params->get('id')) {
            $image = Asset::findById($id);
                
            if ($image) {
                return $image;
            }
        }

        if ($path = $this->params->get('path')) {
            $image = Asset::findByPath($path);
                
            if ($image) {
                return $image;
            }
        }

        if ($url = $this->params->get('url')) {
            $image = Asset::findByUrl($url);
                
            if ($image) {
                return $image;
            }
        }
        
        return $this->params->get('image');
    }
}
