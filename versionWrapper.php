<?php
/**
 *
 * This file is part of Open Library System.
 * Copyright © 2009, Dansk Bibliotekscenter a/s,
 * Tempovej 7-11, DK-2750 Ballerup, Denmark. CVR: 15149043
 *
 * Open Library System is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Open Library System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Open Library System.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * \brief Entry point for webservice.
 *    
 *  Branch to subdirectory to facilitate support of different versions 
 *  of a service
 *  
 *  Version can be set in the request (rest, xml or soap) by setting version
 *  (&version= ... or <version>...</version>)
 * 
 *  Different version of a service should be in sub-directories like
 *     .../myWebService/
 *     .../myWebService/1.0/
 *     .../myWebService/1.2/
 *     .../myWebService/1.3/
 *  and the current version should be in current. So if the current version 
 *  is 1.2 make a symbolic link like
 *     ln -s 1.2 current
 *
 * 
 */

if (!$version = $_GET["version"]) 
  if ($GLOBALS["HTTP_RAW_POST_DATA"]) {
     $dom = new DomDocument;
     $dom->loadXml($GLOBALS["HTTP_RAW_POST_DATA"]);
     $version = $dom->getElementsByTagName("version")->item(0)->nodeValue;
  } else
    $version = "current";

if (!is_dir($version))
  header("HTTP/1.0 400 Bad request");
else
  include $version."/index.php";

?>
