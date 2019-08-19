<?php


namespace Rekkles\AppStoreScrape\Lib;


class Search extends App
{
    const SEARCH_URL = 'https://itunes.apple.com/WebObjects/MZStore.woa/wa/search';

    /**
     * Get All App By Keyword
     * @param $keyword
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAppByKeyword($keyword)
    {
        $url = self::SEARCH_URL;

        $client = $this->getHttpClient();
        $query = [
            'clientApplication' => 'Software',
            'media' => 'software',
            'term' => $keyword,
        ];
        $result = $client->request('get', $url, [
            'headers' => $this->header,
            'query' => $query,
        ]);

        $result = json_decode($result->getBody()->getContents(), true);

        return $result;
    }

    /**
     * Get App rank num by keyword
     * @param $keyword
     * @param $appId
     * @param null $limit
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAppRankByKeyword($keyword, $appId, $limit = null)
    {
        $data = ($this->getAppByKeyword($keyword))['bubbles'][0]['results'];

        $allAppRank = is_null($limit) ? $data : array_slice($data, 0, $limit);

        if (empty($allAppRank)) {
            return 0;
        }

        for ($i = 0; $i < count($allAppRank); $i++) {
            if ($allAppRank[$i]['id'] == $appId) {
                return $i + 1;
            }
        }
        return 0;
    }
}