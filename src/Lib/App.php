<?php


namespace Rekkles\AppStoreScrape\Lib;

use Rekkles\AppStoreScrape\Exceptions\HttpException;

class App extends Scrape
{

    const LOOKUP_URL = 'https://itunes.apple.com/lookup';

    /**
     * Get App By appId
     * @param string|array $id
     * @param string $entity
     * @param string $country
     * @return mixed
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApp($id, string $entity = 'software', string $country = 'cn')
    {
        $url = self::LOOKUP_URL;

        $id = is_array($id) ? implode(',', $id) : $id;

        $client = $this->getHttpClient();
        $query = [
            'entity' => $entity,
            'country' => $country,
            'id' => $id,
        ];

        $result = $client->request('get', $url, [
            'headers' => $this->header,
            'query' => $query,
        ]);
        return json_decode($result->getBody()->getContents(), true);

    }
}