<?php


namespace Rekkles\AppStoreScrape\Lib;


class RSS extends Scrape
{
    const BASE_URL = 'https://rss.itunes.apple.com/api/v1/';

    const REGION = [
        'cn',
        'dk',
        'ua',
        'uz',
        'ug',
        'uy',
        'td',
        'ye',
        'am',
        'il',
        'bz',
        'cv',
        'ru',
        'bg',
        'hr',
        'gm',
        'is',
        'gw',
        'cg',
        'lr',
        'ca',
        'gh',
        'hu',
        'za',
        'bw',
        'qa',
        'lu',
        'in',
        'id',
        'gt',
        'ec',
        'tw',
        'kg',
        'kz',
        'co',
        'cr',
        'tm',
        'tr',
        'lc',
        'kn',
        'st',
        'vc',
        'gy',
        'tz',
        'eg',
        'tj',
        'sn',
        'sl',
        'cy',
        'sc',
        'mx',
        'dm',
        'do',
        'at',
        've',
        'ao',
        'ai',
        'ag',
        'fm',
        'ni',
        'ng',
        'ne',
        'np',
        'bs',
        'pk',
        'bb',
        'pg',
        'py',
        'pa',
        'bh',
        'br',
        'bf',
        'gr',
        'pw',
        'ky',
        'de',
        'it',
        'sb',
        'lv',
        'no',
        'cz',
        'md',
        'bn',
        'fj',
        'sz',
        'sk',
        'si',
        'lk',
        'sg',
        'nz',
        'jp',
        'cl',
        'kh',
        'gd',
        'be',
        'mr',
        'mu',
        'sa',
        'fr',
        'pl',
        'th',
        'zw',
        'hn',
        'au',
        'mo',
        'ie',
        'ee',
        'jm',
        'tc',
        'tt',
        'bo',
        'se',
        'ch',
        'by',
        'bm',
        'kw',
        'pe',
        'tn',
        'lt',
        'jo',
        'na',
        'ro',
        'us',
        'la',
        'ke',
        'fi',
        'sr',
        'gb',
        'vg',
        'nl',
        'mz',
        'ph',
        'sv',
        'pt',
        'mn',
        'ms',
        'es',
        'bj',
        'vn',
        'az',
        'dz',
        'al',
        'om',
        'ar',
        'ae',
        'kr',
        'hk',
        'mk',
        'mw',
        'my',
        'mt',
        'mg',
        'ml',
        'lb',
    ];

    const MEDIA_TYPE = ['apple-music', 'ios-apps', 'itunes-u', 'podcasts'];
    const FEED_TYPE = [
        'apple-music' => [
            'comming-soon', 'hot-tracks', 'new-releases', 'top-albums', 'top-songs'
        ],
        'ios-apps' => [
            'new-app-we-love', 'new-games-we-love', 'top-free', 'top-free-ipad', 'top-grossing',
            'top-grossing-ipad', 'top-paid'
        ],
        'itunes-u' => [
            'top-itunes-u-courses'
        ],
        'podcasts' => [
            'top-podcasts'
        ]
    ];
    const TYPE = ['top-free' => ['all', 'games'], 'top-paid' => ['all', 'games']];

    private $region;
    private $mediaType;
    private $feedType;
    private $type;
    private $limit = 100;
    private $eighteenR;

    /**
     * RSS constructor.
     * @param $config
     */
    public function __construct($config)
    {
        foreach ($config as $key => $value) {
            $function = 'set' . ucfirst($key);
            if (method_exists($this, $function)) {
                $this->$function($value);
            }
        }
    }

    /**
     * Get app rank
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAppRankInfo()
    {
        $url = self::BASE_URL . $this->region . '/' .
            $this->mediaType . '/' . $this->feedType . '/' . $this->type . '/' . $this->limit . '/' . $this->eighteenR . '.json';

        $client = $this->getHttpClient();
        $result = $client->request('get', $url, [
            'headers' => $this->header
        ]);

        $result = json_decode($result->getBody()->getContents(), true);

        return $result;
    }

    public function setRegion($region)
    {
        if (!in_array($region, self::REGION)) {
            throw new \Exception('Not Support region, support list' . json_encode(self::REGION));
        }
        $this->region = $region;
        return $this;
    }

    public function setMediaType($mediaType)
    {
        if (!in_array($mediaType, self::MEDIA_TYPE)) {
            throw new \Exception('Not support mediaType,support list' . json_encode(self::MEDIA_TYPE));
        }
        $this->mediaType = $mediaType;
        return $this;
    }

    public function setFeedType($feedType)
    {
        if (empty($this->mediaType)) {
            throw new \Exception('Please put the mediaType in front of the feedType');
        }
        if (!in_array($feedType, self::FEED_TYPE[$this->mediaType])) {
            throw new \Exception('This mediaType not support ' . $feedType . ', 
            This mediaType Support feedType list' . json_encode(self::FEED_TYPE[$this->mediaType]));
        }
        $this->feedType = $feedType;
        return $this;
    }

    public function setLimit($limit)
    {
        if (!is_int($limit)) {
            throw new \Exception('Limit must be int');
        }
        $this->limit = $limit;
        return $this;
    }

    public function setType($type)
    {
        if (empty($this->feedType)) {
            throw new \Exception('Please put the feedType in front of the type');
        }
        if (!in_array($type, self::TYPE[$this->feedType])) {
            throw new \Exception('This feedType not support ' . $type . ', 
            This feedType Support Type list' . json_encode(self::TYPE[$this->feedType]));
        }
        $this->type = $type;
        return $this;
    }

    public function setEighteenR($eighteenR)
    {
        if (!is_bool($eighteenR)) {
            throw new \Exception('Only support true or false');
        }
        $this->eighteenR = $eighteenR ? 'explicit' : 'non-explicit';
    }
}