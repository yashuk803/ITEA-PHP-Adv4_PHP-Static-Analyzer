PHP Static Analyzer
===================

![Custom badge](https://img.shields.io/badge/greeflas-default--project-red.svg)

Installation
------------

TODO

Usage
-----

`$ ./bin/console class-author-stat <projectDir> <developerEmail>` - counts classes/interfaces/trait
created by some developer in project.

`$ ./bin/console class-signature-stat <fullClassName> ` - get info about signature classes
(fullClassName - Namespace and name class in single quotes).

Code style fixer
----------------


To fix the code style just run the following command

```
$ composer cs-fix
```

License
-------

[![license](https://img.shields.io/github/license/greeflas/default-project.svg)](LICENSE)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2019, Vladimir Kuprienko
