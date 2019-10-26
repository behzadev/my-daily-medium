<?php

namespace App\Service;

use App\Entity\Article;
use Intervention\Image\ImageManagerStatic as Image;

class MediumImage
{
    public function copyImageToLocal(Article $article)
    {
        $imgExt = pathinfo($article->getImage(), PATHINFO_EXTENSION) != '' ? '.' . pathinfo($article->getImage(), PATHINFO_EXTENSION) : '.jpg';
        
        $imgName = rand(1, 99999) . $imgExt;

        copy($article->getImage(), $_ENV['IMG_TMP_PATH'] . $imgName);    

        return $_ENV['IMG_TMP_PATH'] . $imgName;
    }

    /**
     * Apply overlay on image
     *
     * @param string $imagePath
     * @return string
     */
    public function applyOverlay(string $imagePath): string
    {
        $img = Image::make($imagePath);

        $img->insert('public/images/watermark.png', 'bottom-center');

        $img->save($imagePath);

        return $imagePath;
    }

    public function resize(string $imagePath): string
    {
        $img = Image::make($imagePath);

        $img->resize(1080, null);

        $img->save($imagePath);

        return $imagePath;
    }
}
