MarkDown parser
===============

http://parsedown.org/

---------------------------------------

Aspect ratio images
===================

http://jsfiddle.net/danield770/8VJ38/3/ -> příklad, použito
https://stackoverflow.com/questions/1495407/maintain-the-aspect-ratio-of-a-div-with-css
http://dabblet.com/gist/2590942 -> příklad
https://css-tricks.com/aspect-ratio-boxes/
https://www.w3schools.com/howto/howto_css_aspect_ratio.asp

---------------------------------------

How to prevent html5 page from caching?

https://stackoverflow.com/questions/15228697/how-to-prevent-html5-page-from-caching


https://php.earth/docs/security/passwords
https://stackoverflow.com/questions/45536537/centering-in-css-grid
https://css-tricks.com/snippets/css/complete-guide-grid/ 
https://stackoverflow.com/questions/45786788/css-grid-layout-not-working-in-edge-and-ie-11-even-with-ms-prefix
https://rachelandrew.co.uk/archives/2016/11/26/should-i-try-to-use-the-ie-implementation-of-css-grid-layout/
https://speckyboy.com/custom-hover-click-effects-css-javascript/


A simple example using finalize().

// Open the database connection
$db = new SQLite3('database.db');

// Prepare a query for execution
$query = $db->prepare('SELECT user_id FROM users WHERE username=:username');
$query->bindValue(':username', $_COOKIE['username'], SQLITE3_TEXT);

// Execute the query
$result = $query->execute();

// Store the result of the query
$id = $result->fetchArray(SQLITE3_NUM)[0];

// Close the result set and database connection
$result->finalize();
$db->close();

Of course you should be more careful and clean your cookie, etc.

--------------------

The recommended way to do a SQLite3 query is to use a statement. For a table creation, 
a query might be fine (and easier) but for an insert, update or select, you should really use a statement, 
it's really easier and safer as SQLite will escape your parameters according to their type. SQLite will also use 
less memory than if you created the whole query by yourself. Example:

<?php

$db = new SQLite3;
$statement = $db->prepare('SELECT * FROM table WHERE id = :id;');
$statement->bindValue(':id', $id);

$result = $statement->execute();

?>

You can also re-use a statement and change its parameters, just do $statement->reset(). Finally don't forget to close 
a statement when you don't need it anymore as it will free some memory.

---------------------

Check with SQLite3Result::numColumns() for an empty result before calling SQLite3Result::fetchArray().

In contrast to the documentation SQLite3::query() always returns a SQLite3Result instance, not only for queries returning rows 
(SELECT, EXPLAIN). Each time SQLite3Result::fetchArray() is called on a result from a result-less query internally the query is executed again, 
which will most probably break your application.

For a framwork or API it's not possible to know in before whether or not a query will return rows (SQLite3 supports multi-statement queries). 
Therefore the argument "Don't execute query('CREATE ...')" is not valid.

-------------------------------------

SQL paging
==========

https://stackoverflow.com/questions/14468586/efficient-paging-in-sqlite-with-millions-of-records


Please note that you always have to use an ORDER BY clause; otherwise, you get just some random order.

To do efficient paging, save the first/last displayed values of the ordered field(s), and continue just after them when displaying the next page:

SELECT *
FROM MyTable
WHERE SomeColumn > LastValue
ORDER BY SomeColumn
LIMIT 100;

(This is explained with more detail on the SQLite wiki.)

When you have multiple sort columns (and SQLite 3.15 or later), you can use a row value comparison for this:

SELECT *
FROM MyTable
WHERE (SomeColumn, OtherColumn) > (LastSome, LastOther)
ORDER BY SomeColumn, OtherColumn
LIMIT 100;

---------------------------------------

HTTPS Redirection
=================

https://stackoverflow.com/questions/4398951/force-ssl-https-using-htaccess-and-mod-rewrite
https://stackoverflow.com/questions/85816/how-can-i-force-users-to-access-my-page-over-https-instead-of-http

# HTTPS redirection.

# If we receive a forwarded http request from a proxy...
RewriteCond %{HTTP:X-Forwarded-Proto} =http [OR]

# ...or just a plain old http request directly from the client
RewriteCond %{HTTP:X-Forwarded-Proto} =""
RewriteCond %{HTTPS} !=on

# Redirect to https version
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

-------------------------------------------

PowerShell - Renaming files

 get-childitem -recurse *.jpeg | foreach { rename-item $_ $_.Name.Replace(".jpeg", ".jpg") }