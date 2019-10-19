<?php

namespace App\Command;

use InstagramAPI\Instagram;
use App\Service\MediumImage;
use App\Repository\ArticleRepository;
use InstagramAPI\Media\Photo\InstagramPhoto;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendPostCommand extends Command
{
    protected static $defaultName = 'app:send-post';

    private $articleRepository;

    private $mediumImage;

    private $debug = true;

    private $truncatedDebug = true;

    public function __construct(ArticleRepository $articleRepository, MediumImage $mediumImage)
    {
        $this->articleRepository = $articleRepository;
        
        $this->mediumImage = $mediumImage;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetchs a post from articles table and post it to Instagram');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $instagram = new Instagram($this->debug, $this->truncatedDebug);

        try {
            $instagram->login($_ENV['INSTAGRAM_USERNAME'], $_ENV['INSTAGRAM_PASSWORD']);
        } catch (\Exception $e) {
            echo 'Something went wrong: '.$e->getMessage()."\n";
        }

        // Get article
        $article = $this->articleRepository->getBySentStatus(false);

        // Get a local copy of image
        $imageLocalPath = $this->mediumImage->copyImageToLocal($article);
        
        try {
            $photo = new InstagramPhoto($imageLocalPath);
            $instagram->timeline->uploadPhoto($photo->getFile(), ['caption' => $article->getText()]);
        } catch (\Exception $e) {
            echo 'Something went wrong: '.$e->getMessage()."\n";
        }
        
        $io->success('Post sent :)');
    }
}
