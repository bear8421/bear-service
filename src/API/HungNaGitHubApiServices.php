<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 27/01/2024
 * Time: 16:03
 */

namespace Bear8421\Bear\Services\API;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Request\Request;
use Bear8421\Bear\Services\Traits\Helper;
use Bear8421\Bear\Services\Traits\Response;
use Bear8421\Bear\Services\Traits\Version;

class HungNaGitHubApiServices implements Environment
{
    use Version, Helper, Response;

    const GITHUB_STATIC_REPO_API = 'https://api.github.com/repositories/740265525/contents/';
    const GITHUB_STATIC_DOMAIN = 'https://hungna.github.io/';

    protected function request(): Request
    {
        return new Request();
    }

    public function getDataBackground(string $location_id = ''): array
    {
        $location_id = trim($location_id);
        $githubApi = self::GITHUB_STATIC_REPO_API . 'assets/background/' . $location_id;
        $fetchData = $this->request()->sendRequest($githubApi);
        $jsonData = json_decode($fetchData);
        if ($jsonData === null) {
            return [];
        }
        $data = array();
        foreach ($jsonData as $item) {
            $data[] = self::GITHUB_STATIC_DOMAIN . $item->path;
        }
        return $data;
    }
}
