![](/pure.png?raw=true)
---------

Pure search is a search engine that can crawl websites for a specified amount of pages, store them in a database, and then search said database. Since it is an old project, many of the search plugins are no longer functional because the APIs used no longer exist. 

You can add websites to the crawler through a control panel, which requires a login. The hash function for passwords is in the source code.

##Requirements
- A php, apache, and mysql(mariadb) setup
- The PDO php plugin
- tidy

This has been locally tested on an Archlinux system.

##Credits
- The Crawler class is from http://phpcrawl.cuab.de/about.html, and is licensed under the GPL2 license.
