<?php


namespace Rekkles\AppStoreScrape\Lib;


class Comments extends Scrape
{

    private $sort = [
        'RECENT' => 'mostRecent',
        'HELPFUL' => 'mostHelpful'
    ];

    /**
     * Get App's Comments
     * @param $id
     * @param string $country
     * @param int $page
     * @param string $sort
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getComments($id, $country = 'cn', $page = 1, $sort = 'RECENT')
    {
        if (!in_array($sort, array_keys($this->sort))) {
            throw new \Exception('Invalid [key] sort,only support RECENT or HELPFUL');
        }

        $url = "https://itunes.apple.com/$country/rss/customerreviews/page=$page/id=$id/sortby=$sort/json";

        $client = $this->getHttpClient();
        $result = $client->request('get', $url, [
            'headers' => $this->header
        ]);

        $result = json_decode($result->getBody()->getContents(), true);

        return $result;
    }
}