<?php


namespace Rekkles\AppStoreScrape\Lib;


class Ratings extends Scrape
{

    /**
     * Get App's Rating
     * @param $id
     * @param string $country
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRatings($id, $country = 'cn')
    {
        $url = "https://itunes.apple.com/$country/customer-reviews/id$id?displayable-kind=11 ";

        $client = $this->getHttpClient();
        $result = $client->request('get', $url, [
            'headers' => $this->header
        ]);

        $result = json_decode($result->getBody()->getContents(), true);

        return $result;
    }
}