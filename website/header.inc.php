<?php

echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>CRUX port browser</title>
    <link rel="stylesheet" type="text/css" href="portdb.css"/>
    <link rel="search" type="application/opensearchdescription+xml" href="opensearch.xml" title="CRUX portdb search"/>
  </head>
  <body>
    <div class="cruxheader">
      <a href="/" title="">Home</a> :: 
      <a href="/Main/Documentation">Documentation</a> :: 
      <a href="/Main/Download">Download</a> :: 
      <a href="/Main/Development">Development</a> :: 
      <a href="/Main/Community">Community</a> :: 
      <a href="/Wiki/HomePage">Wiki</a> :: 
      <a href="/portdb">Ports</a> :: 
      <a href="/Main/Bugs" title="">Bugs</a> :: 
      <a href="/Main/Links" title="">Links</a> :: 
      <a href="/Main/About" title="">About</a>
    </div>
    <form method="get" action="/portdb/" enctype="application/x-www-form-urlencoded">
	<div class="search">
	<input type="hidden" name="a" value="search" />
	search ports:
	<input type="text" name="q" size="10"  />
	</div>
    </form>
    <div class="content">
      <b>Sections: </b><a href="?a=index">Repositories</a> :: <a href="?a=ports">Ports</a> :: <a href="?a=search">Search</a> :: <a href="?a=register">Register</a> :: <a href="?a=dups">Duplicates</a>
HTML;
