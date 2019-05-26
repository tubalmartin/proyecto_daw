<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

    public function getNowPlayingMovies($page) {
        $response = $this->client->getMoviesApi()->getNowPlaying([
            'page' => $page,
            'region' => 'ES'
        ]);

        $response['results'] = $this->addFullImagePaths($response['results']);

        return $response;
    }

    public function getUpcomingMovies($page) {
        $response = $this->client->getMoviesApi()->getUpcoming([
            'page' => $page,
            'region' => 'ES'
        ]);

        $response['results'] = $this->addFullImagePaths($response['results']);

        return $response;
    }

    public function getPopularMovies($page) {
        $response = $this->client->getMoviesApi()->getPopular([
            'page' => $page,
            'region' => 'ES'
        ]);

        $response['results'] = $this->addFullImagePaths($response['results']);

        return $response;
    }

    public function getTopRatedMovies($page) {
        $response = $this->client->getMoviesApi()->getTopRated([
            'page' => $page,
            'region' => 'ES'
        ]);

        $response['results'] = $this->addFullImagePaths($response['results']);

        return $response;
    }

    public function getSearchResults($query, $page) {
        $response = $this->client->getSearchApi()->searchMulti($query, [
            'page' => $page,
            'region' => 'ES'
        ]);
        $response['results'] = $this->addFullImagePaths(array_filter($response['results'], function($result) {
            return $this->isValidMovie($result) || $this->isValidPerson($result);
        }));

        return $response;
    }

    public function getMovie($id) {
        $response = $this->client->getMoviesApi()->getMovie($id, ['append_to_response' => 'credits,similar']);

        $response['credits']['cast'] = $this->getFirstElements($response['credits']['cast'],8);
        $response['credits']['crew'] = $this->filterCrewByJob($response['credits']['crew'], 'Director');

        return $this->addFullImagePaths($response);
    }

    public function getPerson($id) {
        $response = $this->client->getPeopleApi()->getPerson($id, ['append_to_response' => 'movie_credits']);

        $response['known_for_department'] = $this->getTranslatedDepartment($response['known_for_department']);
        $response['gender'] = $this->getTranslatedGender($response['gender']);

        if (isset($response['movie_credits']['cast'])) {
            $this->sortByReleaseDateDesc($response['movie_credits']['cast']);
            $response['movie_credits']['cast'] = $this->getFirstElements($response['movie_credits']['cast'], 8);
        }

        if (isset($response['movie_credits']['crew'])) {
            $crew = [];
            $this->sortByReleaseDateDesc($response['movie_credits']['crew']);
            $crew['directing'] = $this->getFirstElements($this->filterCrewByDepartment($response['movie_credits']['crew'], 'Directing'), 8);
            $crew['production'] = $this->getFirstElements($this->filterCrewByDepartment($response['movie_credits']['crew'], 'Production'), 8);
            $response['movie_credits']['crew'] = $crew;
        }

        return $this->addFullImagePaths($response);
    }

    private function getTranslatedGender($gender) {
        switch($gender) {
            case 1:
                return 'Femenino';
            case 2:
                return 'Masculino';
            default:
                return 'Otro';
        }
    }

    private function getTranslatedDepartment($department) {
        switch($department) {
            case 'Acting':
                return 'Interpretación';
            case 'Directing':
                return 'Dirección';
            case 'Production':
                return 'Producción';
            default:
                return 'Otro';
        }
    }

    private function getFirstElements($list, $n) {
        return array_slice($list, 0, $n, true);
    }

    private function sortByReleaseDateDesc(&$data) {
        usort($data, function($a, $b) {
            $date1 = isset($a['release_date']) ? $a['release_date'] : '00-00-0000';
            $date2 = isset($b['release_date']) ? $b['release_date'] : '00-00-0000';

            if ($date1 === $date2) {
                return 0;
            }
            return ($date1 < $date2) ? 1 : -1;
        });
    }

    private function filterCrewByJob($data, $job) {
        return array_filter($data, function($member) use ($job) {
            return $member['job'] === $job;
        });
    }

    private function filterCrewByDepartment($data, $department) {
        return array_filter($data, function($member) use ($department) {
            return $member['department'] === $department;
        });
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
                    if (preg_match("/_path$/", $key)) {
                        $data[$key] = empty($value)
                            ? 'https://via.placeholder.com/150x225?text=?'
                            : $this->imageHelper->getUrl($value);
                    }
                }
            }
        }

        return $data;
    }
}