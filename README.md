PHP DuckDuckGo Search 

This is a PHP class that allows you to search DuckDuckGo from your PHP application.

## Installation

You can install this package via composer:

```bash

composer require mathsgod/duckduckgo-search-php

```


## Usage

```php

$ddg=new DuckDuckGo;
$results=$ddg->search('php');

```

### Region

You can also search in a specific region:

```php

$ddg=new DuckDuckGo;
$results=$ddg->search('php','hk-tzh');//Hong Kong

```

### Time range

You can also search in a specific time range:

```php

$ddg=new DuckDuckGo;
$results=$ddg->search('php','hk-tzh','m');//Last month

```





