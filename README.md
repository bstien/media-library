# Media Library

The goal of this package is to keep control and tidyness in your media library. As of now, only TV-shows are supported. Movies will be in the future.

I will try to keep this package as framework-agnostic as possible, but for now it is developed with and for Laravel 5.

The structure of the library:
```
[media root]
  Serie
    Season
      Episode
```



[TheTVDB.com](http://thetvdb.com/) is used to scrape information about the series. Be sure to get an API-key for their services [here](http://thetvdb.com/?tab=apiregister) and place this in the config-file.
