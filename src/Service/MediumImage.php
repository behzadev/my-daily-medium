<?php

namespace App\Service;

use App\Entity\Article;

class MediumImage
{
    public function copyImageToLocal(Article $article)
    {
        $imgExt = pathinfo($article->getImage(), PATHINFO_EXTENSION) != '' ? '.' . pathinfo($article->getImage(), PATHINFO_EXTENSION) : '.jpg';
        
        $imgName = rand(1, 99999) . $imgExt;

        copy($article->getImage(), $_ENV['IMG_TMP_PATH'] . $imgName);    

        return $_ENV['IMG_TMP_PATH'] . $imgName;
    }
}
