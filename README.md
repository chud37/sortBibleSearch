# sortBibleSearch()
Takes an string and outputs an array of bible chapters, verses for easy searching.


## Examples ##

Perform a regular search:
```
$results = sortBibleSearch("Matthew 1:1");
// array (
//   'BookNumber' => false,
//   'Book' => 'Matthew',
//   'Chapter' => '1',
//   'StartVerse' => '1',
//   'EndVerse' => false,
//   'QueryType' => 1,
// )
```

Books with numbers before them:
```
$results = sortBibleSearch("1 John 4:17");
// array (
//   'BookNumber' => '1',
//   'Book' => '1 John',
//   'Chapter' => '4',
//   'StartVerse' => '17',
//   'EndVerse' => false,
//   'QueryType' => 1,
// )
```

You can use abbreviations too
```
$results = sortBibleSearch("Gen 2:5");
// array (
//   'BookNumber' => false,
//   'Book' => 'Genesis',
//   'Chapter' => '2',
//   'StartVerse' => '5',
//   'EndVerse' => false,
//   'QueryType' => 1,
// )
```

Also handles start verse and end verse.
```
$results = sortBibleSearch("1 Corinthians 3:4-5");
// array (
//   'BookNumber' => '1',
//   'Book' => '1 Corinthians',
//   'Chapter' => '3',
//   'StartVerse' => '4',
//   'EndVerse' => '5',
//   'QueryType' => 2,
// )
```

If no book is found, returns false.
```
$results = sortBibleSearch("1 Corinthians 3:4-5");
// false
```

## Usage ##
Simply include the file sortBibleSearch.php and you're good to go.

```
include("sortBibleSearch.php");
$results = sortBibleSearch("gen 2:4");
```
