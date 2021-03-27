<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MinifyCssCommand extends Command
{
    protected static $defaultName = 'app:minify-css';
    protected static $defaultDescription = 'Add a short description for your command';

    /** @noinspection ReturnTypeCanBeDeclaredInspection */
    protected function configure()
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // setup the URL and read the CSS from a file
        $url = 'https://cssminifier.com/raw';
        $source = __DIR__ . '/../../public/css/default.css';
        $target = __DIR__ . '/../../public/css/default.min.css';
        $css = file_get_contents($source);

        // init the request, set various options, and send it
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
            CURLOPT_POSTFIELDS => http_build_query([ "input" => $css ])
        ]);

        $minified = curl_exec($ch);

        // finally, close the request
        curl_close($ch);

        // output the $minified css
        file_put_contents($target, $minified);

        return Command::SUCCESS;
    }
}
