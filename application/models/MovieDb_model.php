<?php

class MovieDb_model extends CI_Model
{
    private $apiKey = '3b4c51ca154dd5aa7742cd8d12e45017';
    private $token;
    private $client;
    private $configRepository;
    private $imageHelper;

    public function __construct()
    {
        parent::__construct();

        $this->token  = new \Tmdb\ApiToken($this->apiKey);
        $this->client = new \Tmdb\Client($this->token);
        $configRepository = new \Tmdb\Repository\ConfigurationRepository($this->client);
        $this->client->getHttpClient()->addSubscriber(new \Tmdb\HttpClient\Plugin\LanguageFilterPlugin('es-ES'));
        $this->configRepository = $configRepository->load();
        $this->imageHelper = new \Tmdb\Helper\ImageHelper($this->configRepository);
    }

    public function getNowPlayingMovies() {
        $response = $this->client->getMoviesApi()->getNowPlaying([
            'page' => 1,
            'region' => 'ES'
        ]);

        return $this->addFullImagePaths($response['results']);
    }

    public function getUpcomingMovies() {
        $response = $this->client->getMoviesApi()->getUpcoming([
            'page' => 1,
            'region' => 'ES'
        ]);

        return $this->addFullImagePaths($response['results']);
    }

    public function getSearchResults($query) {
        $response = $this->client->getSearchApi()->searchMulti($query);
        $filteredResults = array_filter($response['results'], function($result) {
            return $this->isValidMovie($result) || $this->isValidPerson($result);
        });

        return $this->addFullImagePaths($filteredResults);
    }

    public function getMovie($id) {
        $response = $this->client->getMoviesApi()->getMovie($id, ['append_to_response' => 'credits']);

        $response['credits']['cast'] = array_slice($response['credits']['cast'], 0, 8, true);
        $response['credits']['crew'] = array_filter($response['credits']['crew'], function($member) {
            return $member['job'] === 'Director';
        });

        return $this->addFullImagePaths($response);
    }

    public function getPerson($id) {

    }

    private function isValidMovie($item) {
        return $item['media_type'] === 'movie' && !empty($item['poster_path']);
    }

    private function isValidPerson($item) {
        return $item['media_type'] === 'person' && !empty($item['profile_path']);
    }

    private function addFullImagePaths($data) {
        if (is_array($data)) {
            foreach($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = $this->addFullImagePaths($value);
                } else {
                    if (preg_match("/_path$/", $key) && !empty($value)) {
                        $data[$key] = $this->imageHelper->getUrl($value);
                    }
                }
            }
        }

        return $data;
    }
}