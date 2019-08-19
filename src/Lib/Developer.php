<?php


namespace Rekkles\AppStoreScrape\Lib;


class Developer extends Scrape
{

    /**
     * Get developer's metadata
     * @param $devId
     * @param string $country
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDeveloperMetadata($devId, $country = 'cn')
    {

        $url = "https://itunes.apple.com/lookup?id=$devId&country=$country&entity=software";

        $client = $this->getHttpClient();
        $result = $client->request('get', $url, [
            'headers' => $this->header
        ]);

        $result = json_decode($result->getBody()->getContents(), true);

        return $result;
    }


    /**
     * Get developer's App
     * @param $devId
     * @param string $country
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDevApp($devId, $country = 'cn')
    {
        $metaData = $this->getDeveloperMetadata($devId, $country);

        $url = $metaData['results'][0]['artistLinkUrl'];

        $client = $this->getHttpClient();
        $result = $client->request('get', $url, [
            'headers' => $this->header
        ]);

        $result = json_decode($result->getBody()->getContents(), true);

        return $result;
    }
}