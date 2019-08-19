<h1 align="center"> app-store-scrape </h1>

<p align="center"> 🎇 A Simple Way To Get AppStore Info.</p>


## Installing

```shell
$ composer require rekkles/app-store-scrape -vvv
```

## Usage

获取指定 AppId 信息

```php
use Rekkles\AppStoreScrape\AppStore;

$entity = 'software'; // 全部 App
$country = 'cn'; //地区,可参考https://rss.itunes.apple.com/zh-cn
$appId = '292374531'; // 请替换这个参数

//获取指定 AppId 信息
$app = AppStore::App()->getApp($appId,$entity,$country);

//获取指定 App 评论信息
$page = 1;//页码
$sort = 'RECENT'; //排序规则 RECENT(最近) or HELPFUL(最有用)
$comments = AppStore::Comments()->getComments($appId,$country,$page,$sort);

//获取开发者应用信息
$devId = 292374531;//开发者Id
$developer = AppStore::Developer()->getDeveloperMetadata($devId,$country);
//获取开发者下面 App 信息
$developerApp = AppStore::Developer()->getDevApp($devId,$country);

//获取 App 评分信息
$ratings = AppStore::Ratings()->getRatings($appId,$country);

//根据关键词搜索排名信息
$keyword = '微信';
$search = AppStore::Search()->getAppByKeyword($keyword);
//判断指定 App 在第几位
$search = AppStore::Search()->getAppRankByKeyword($keyword,$appId);

//获取排行榜信息 参考https://rss.itunes.apple.com/zh-cn
$config = [
    'region' => 'cn', //地区
    'mediaType' => 'ios-apps', //媒体类型
    'feedType' => 'top-free', //feed 类型
    'type' => 'games', //类型
    'limit' => 100, //限制条数
    'eighteenR' => true, //允许儿童不宜内容
  ];
$rss = AppStore::RSS()->getAppRankInfo();


```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/rekkles/app-store-scrape/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/rekkles/app-store-scrape/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT