<?php

namespace App\Service;

use App\Entity\Article;
use Intervention\Image\ImageManagerStatic as Image;

class MediumImage
{
    private $article;

    private $image;

    private $imagePath;

    /**
     * Set article to work on
     *
     * @param Article $article
     * @return self
     */
    public function setArtcile(Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Copy article image to localhost for manipulation
     *
     * @return self
     */
    public function copyImageToLocal(): self
    {
        $imgExt = pathinfo($this->article->getImage(), PATHINFO_EXTENSION) != '' ? '.' . pathinfo($this->article->getImage(), PATHINFO_EXTENSION) : '.jpg';
        
        $imgName = rand(1, 99999) . $imgExt;

        copy($this->article->getImage(), $_ENV['IMG_TMP_PATH'] . $imgName);
        
        $this->imagePath = $_ENV['IMG_TMP_PATH'] . $imgName;
        
        return $this;
    }

    /**
     * Resize local article image to fit Instagram size
     *
     * @return self
     */
    public function resize(): self
    {
        $this->image = Image::make($this->imagePath);

        $this->image->resize(1080, null);

        $this->image->save($this->imagePath);

        return $this;
    }

    /**
     * Apply overlay image on the article image
     *
     * @return string
     */
    public function applyOverlay(): string
    {
        $this->image->insert('public/images/watermark.png', 'bottom-center');

        $this->image->save($this->imagePath);

        return $this->imagePath;
    }
}
