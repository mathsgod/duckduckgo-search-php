<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class DuckDuckGo
{
    public function search(string $query, int $page = 1, ?string $region = null, ?string $time = null)
    {
        $form_params = [
            'q' => $query,
            'dc' => $page
        ];

        if ($region) {
            $form_params['kl'] = $region;
        }

        if ($time) {
            $form_params['t'] = $time;
        }

        $client = new Client(["verify" => false]);
        $response = $client->post('https://lite.duckduckgo.com/lite/', [
            'form_params' => $form_params
        ]);
        $content = $response->getBody()->getContents();

        $crawler = new Crawler($content);

        $weblinks = $crawler->filter('table:nth-of-type(3) .result-link');
        $webSnippets = $crawler->filter('table:nth-of-type(3) .result-snippet');

        $results = $weblinks->each(function (Crawler $node, $i) use ($webSnippets) {
            return [
                "title" => $node->html(),
                "url" => $node->attr('href'),
                "body" => trim($webSnippets->eq($i)->text())
            ];
        });

        return $results;
    }

    function apiExtractText(string $url)
    {
        $client = new Client(["verify" => false]);
        $response = $client->get($url);
        $content = $response->getBody()->getContents();

        $crawler = new Crawler($content);



        return [
            "title" => $crawler->filter('title')->text(),
            "url" => $url,
            "body" => $this->cleanText($crawler->filter('body')->text())
        ];
    }

    private function cleanText(string $text)
    {
        $text = trim($text);

        $text = preg_replace("/(\n){4,}/", "\n\n\n", $text);
        $text = preg_replace("/ {3,}/", " ", $text);
        $text = preg_replace("/(\t)/", "", $text);
        $text = preg_replace("/\n+(\s*\n)*/", "\n", $text);

        return $text;
    }
}
