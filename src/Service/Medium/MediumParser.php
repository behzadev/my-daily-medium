<?php

namespace App\Service\Medium;

class MediumParser
{
    /**
     * Base URL for Medium images
     */
    const IMG_BASE_URL = 'https://miro.medium.com/max/2000/';

    /**
     * Valid paragraph types of a Medium story to be captured as it's text
     */
    const INVALID_PARAGRAPH_TYPES = [
        4, // Photo by...
    ];

    /**
     * Parse HTML output of a Medium story
     *
     * @param string $article
     * @return array
     */
    public static function Parse(string $article): array
    {
        $articleDetails = json_decode($article)->payload->value;

        $articleTitle = $articleDetails->title;

        $articleImage = self::IMG_BASE_URL . $articleDetails->virtuals->previewImage->imageId;

        $articleText = '';
        $articleCharsCount = 0;
        foreach ($articleDetails->content->bodyModel->paragraphs as $key => $paragraph) {
            if (!in_array($paragraph->type, self::INVALID_PARAGRAPH_TYPES)) {
                $articleText.= $paragraph->text . '\r\n';
                $articleCharsCount+= mb_strlen($paragraph->text);
            }
        }

        return [
            'title' => $articleTitle,
            'text' => $articleText,
            'image' => $articleImage,
            'chars_count' => $articleCharsCount,
        ];
    }
}
