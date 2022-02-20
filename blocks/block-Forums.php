<?php

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/

if (stristr($_SERVER['SCRIPT_NAME'], basename(__FILE__)) OR !defined('UN_KERNELFILES_LOADED')) {
    Header("Location: ../index.php");
    die();
}

global $db, $sitename;

$content = "<br>";

$text = '{MENU: path=forum/newforumposts}' ;  
$content = e107::getParser()->parseTemplate($text, true);
 
/*
$result = $db->sql_query("SELECT t.topic_id, t.topic_title FROM ".UN_TABLENAME_PHPBB_TOPICS_TABLE." t, ".UN_TABLENAME_PHPBB_FORUMS_TABLE." f WHERE f.forum_id = t.forum_id AND f.auth_view < 2 AND f.auth_read < 2 ORDER BY topic_time DESC LIMIT 10");
while ($row = $db->sql_fetchrow($result)) {
	$topic_id = $row['topic_id'];
	$topic_title = $row['topic_title'];
	$content .= "<img src=\"images/arrow.gif\" border=\"0\" alt=\"\" title=\"\" width=\"9\" height=\"9\">&nbsp;<a href=\"modules.php?name=Forums&amp;file=viewtopic&amp;t=".$topic_id."\">".$topic_title."</a><br>";
}
$db->sql_freeresult($result);
*/
 