<!doctype html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<title>List document titles and descriptions</title>
<?php
/*
 * PHP script to list document title and description for a list of HTML pages
 * (c) Copyright 2016, Irwin Associates and Graham R Irwin - www.irwinassociates.eu
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify, merge,
 * publish, distribute, sublicense, and/or sell copies of the Software, and to permit 
 * persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or 
 * substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
 * FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * Last modified 05-Oct-16 to add duplicate check
 */
?>
<style>
body {
  font: .83rem Verdana, Arial, Helvetica, sans-serif;
}
h1 {
  font-size: 160%;
}
table {
  border-collapse: collapse;
}
tr:nth-child(odd) {
  background-color: #eef;
}
tr:first-child {
  background-color: #dde;
}
th, td {
  padding: 3px;
  border: 1px solid #ccc;
}
</style>
</head>
<body>
<h1>List of document titles and descriptions</h1>
<table>
  <tr>
    <th scope="col">Document</th>
    <th scope="col">Title 65,69,72</th>
    <th scope="col">Description 150,156,161</th>
  </tr>
  <?php
  // Turn off all error reporting; comment out if you want errors reported
  error_reporting(0);

  // read list of files into array
  $flist = 'urllist.txt';
  if ( !file_exists($flist) )
    die('file '.$flist.' does not exist!');
  $files = file($flist);

  $ignore = array('pdf', 'txt');
  $titles = array();
  $descrs = array();

  // loop all files
  foreach ( $files as $file ) {
    $file = trim($file);

    // check file type
    $extn = substr(strrchr($file, '.'), 1);
    if ( in_array($extn, $ignore) )
      continue;

    // get html
    $doc = new DOMDocument();
    $doc->loadHTMLFile($file);

    // get document title
    $nodes = $doc->getElementsByTagName('title');
    $title = $nodes->item(0)->textContent;
    $t_len = strlen($title);

    // get meta description
    $descr = '';
    $metas = $doc->getElementsByTagName('meta');
    foreach ( $metas as $meta ) {
      $name = $meta->getAttribute("name");
      if ( $name == 'description' )
        $descr = $meta->getAttribute("content");
    }
    $d_len = strlen($descr);

    // output result
    echo '  <tr>', "\n";
    echo '    <td>', substr(strrchr($file, '/'), 1), '</td>', "\n";
    echo '    <td>', $title, ' (', $t_len, ') ';
    if ( in_array($title, $titles) )
      echo ' **';
    echo '</td>', "\n";
    echo '    <td>', $descr, ' (', $d_len, ') ';
    if ( in_array($descr, $descrs) )
      echo ' **';
    echo '</td>', "\n";
    echo '  </tr>', "\n";

    // save to check for duplicates
    $titles[] = $title;
    $descrs[] = $descr;
  }
  ?>
</table>
<p>** indicates a duplicate title or description</p>
</body>
</html>
