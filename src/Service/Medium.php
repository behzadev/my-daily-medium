<?php

namespace App\Service;

use GuzzleHttp\Client;

class Medium
{
    /**
     * Base URL for Medium images
     */
    const IMG_BASE_URL = 'https://miro.medium.com/max/2000/';
    const PROFILE_IMG_BASE_URL = 'https://miro.medium.com/fit/c/160/160/';

    /**
     * Valid paragraph types of a Medium story to be captured as it's text
     */
    const INVALID_PARAGRAPH_TYPES = [
        4, // Photo by...
        14, // Link to external sources
    ];

    /**
     * Get article content as json
     *
     * @param string $articleURL
     * @return string
     */
    public function getArticle(string $articleURL): string
    {
        $client = new Client(['headers' => ['Referer' => 'twitter.com']]);

        $response = $client->request('GET', $articleURL . '?format=json');
        
        return str_replace('])}while(1);</x>', '', $response->getBody());
    }

    /**
     * Parse HTML output of a Medium story
     *
     * @param string $article
     * @return array of article details
     */
    public function Parse(string $article): array
    {
        $articleDetails = json_decode($article)->payload->value;
        $articleRefrence = json_decode($article)->payload->references;

        $authorUserId = $articleDetails->creatorId;
        $authorName = $articleRefrence->User->$authorUserId->name;
        $authorImage = self::PROFILE_IMG_BASE_URL . $articleRefrence->User->$authorUserId->imageId;

        $articleTitle = $articleDetails->title;

        $articleImage = self::IMG_BASE_URL . $articleDetails->virtuals->previewImage->imageId;

        $articleText = '';
        $articleCharsCount = 0;
        $paragraphsCharsCount = 0;
        foreach ($articleDetails->content->bodyModel->paragraphs as $key => $paragraph) {
            if (!in_array($paragraph->type, self::INVALID_PARAGRAPH_TYPES)) {
                $articleText.= $paragraph->text . PHP_EOL . PHP_EOL;
                $articleCharsCount+= mb_strlen($paragraph->text);
                $paragraphsCharsCount++;
            }
        }

        return [
            'title' => $articleTitle,
            'text' => $articleText,
            'image' => $articleImage,
            'author_name' => $authorName,
            'author_image' => $authorImage,
            'chars_count' => $articleCharsCount,
            'paragraphs_count' => $paragraphsCharsCount,
        ];
    }

    /**
     * Returns characters count of string
     *
     * @param string $article
     * @return void
     */
    public function getCharsCount(string $article): int
    {
        return mb_strlen($article);
    }

    /**
     * Returns count paragraphs of article
     *
     * @param string $article
     * @return void
     */
    public function getParagraphsCount(string $article): int
    {
        return count(explode(PHP_EOL, $article)) - 1;
    }
}
