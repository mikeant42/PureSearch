![Image of Purity]
(pure.png?raw=true)
---------

Pure search is a search engine that can crawl websites for a specified amount of pages, store them in a database, and then search said database. It is still a work in progress, and has a large amount of bugs and issues to be sorted out. But, for the most part, it does work as intended. This is an old project, and has recently been dug up. That being said, many of the plugins are outdated and don't work as originally planned, mostly because of lack of maintenance. 

You can add websites to the crawler through a control panel, which requires a login. The hash function for passwords is in the source code.

##Requirements
- A php, apache, and mysql(mariadb) setup
- The PDO php plugin
- tidy

This has been locally tested on an Archlinux system.
