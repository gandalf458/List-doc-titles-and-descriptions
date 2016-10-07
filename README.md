# List-doc-titles-and-descriptions

This is a simple (and possibly incomplete) PHP script to list the document titles and meta descriptions for a set of web pages (most likely a complete website). Its aim is to help with website search engine optimisation by listing the titles and descriptions of all indexable HTML documents in a website in one place, together with the number of characters in each. The script also identifies any duplicate titles and descriptions.

The script is a single file named listmeta.php which contains all the HTML, PHP and CSS code.

The script requires a Yahoo!-style urllist.txt file listing the URLs to be processed. This should be in the same directory as the script, possibly a local directory. Many sitemap generators will create a urllist.txt file as well as a Google sitemap.xml document.
