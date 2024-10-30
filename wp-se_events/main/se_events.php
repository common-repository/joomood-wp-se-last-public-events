<?php


//  Description: JooMood WP Plugins - Retrieve Last X SE Public Events
//	Author: JooMood
//	Version: 1.0
//	Author URI: http://2cq.it/

//	Copyright 2009, JooMOod
//	-----------------------

//	This program is free software: you can redistribute it and/or modify
//	it under the terms of the GNU General Public License as published by
//	the Free Software Foundation, either version 3 of the License, or
//	(at your option) any later version.

//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.

//	You should have received a copy of the GNU General Public License
//	along with this program.  If not, see <http://www.gnu.org/licenses/>.


// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					JOOMOOD START PLAYING
// ----------------------------------------------------------------------------------------------------------------------------------------------------------

// SHOW LAST SE X PUBLIC EVENTS

    include(ABSPATH.'wp-content/plugins/giggi_functions/giggi_database.php');
    require_once(ABSPATH.'wp-content/plugins/giggi_functions/giggi_functions.php');

	$here=$_SERVER['REQUEST_URI'];
	

// Check some data...

if($nametype=="1" OR $nametype=="2") {
$nametypez=$nametype;
} else {
$nametypez="2";
}


		// Check for hidden description
		
		$hiddesc=strtolower($hide_desc);
		if($hiddesc=="yes") {
		$hide_desc="yes";
		} else {
		$hide_desc="no";
		}

		// Check the group description cut-off point
		
        if (preg_match ("/^([0-9.,-]+)$/", $cut_off)) {
        $cut="1";
        } else {
        $cut="0";  // vuol dire che l'utente non ha inserito un numero!
        }

		// Check for Splitted Stats
		
		$split_stat=strtolower($split_stat);
		if($split_stat=="yes") {
		$split="1";
		} else {
		$split="0";
		}

		// Check the Type of date choosen
		
        if (preg_match ("/^([0-9.,-]+)$/", $choose_date)) {
        $chos="1";
        } else {
        $chos="0";  // vuol dire che l'utente non ha inserito un numero!
        }

		if ($chos=="0" OR $choose_date=="0") {
        $choosedate="t.event_datecreated";
		} else if ($choose_date=="1") {
        $choosedate="t.event_date_start";		
		} else {
        $choosedate="t.event_date_end";		
		}
		
				
		// Check if Stats1  are Showed
		
		$show_stat0=strtolower($show_stat0);
		if($show_stat0=="yes") {
		$shows0="1";
		} else {
		$shows0="0";
		}


		// Check if Stats2  are Showed
		
		$show_stat=strtolower($show_stat);
		if($show_stat=="yes") {
		$shows="1";
		} else {
		$shows="0";
		}
		
		// Check personal width & height...

        if (preg_match ("/^([0-9.,-]+)$/", $pic_dim_width)) {
        $my_w="1";
        } else {
        $my_w="0";  // vuol dire che l'utente non ha inserito un numero!
        }
        if (preg_match ("/^([0-9.,-]+)$/", $pic_dim_height)) {
        $my_h="1";
        } else {
        $my_h="0";  // vuol dire che l'utente non ha inserito un numero!
        }

        if($pic_dim_width=="0" OR $pic_dim_height=="0" OR $pic_dim_width=="" OR $pic_dim_height=="" OR $my_w=="0" OR $my_h=="0") {
        $pic_dimensions="0";
        } else {
        $pic_dimensions="1";
        }

        if($pic_dimensions =="1") {
		
		$mywidth=$pic_dim_width;
		$myheight=$pic_dim_height;
		
		} else {
		$mywidth="60";
		$myheight="60";
		
		}

		// Check Num of Groups...

		if($numOfGroup<0) {
		$numOfGroup=1;
		}

		if($how_many_groups>$numOfGroup) {
		$how_many_groups=$numOfGroup;
		}
		
// ---------------------------------------------------------

		// Check Main Box border style
		
		if ($mainbox_border_style=="0" OR $mainbox_border_style=="1" OR $mainbox_border_style=="2") {
		$mainbox_border_res="1";
		} else {
		$mainbox_border_res="0";
		}

		// Check Main Box border color
		
		if ($mainbox_border_color!=='') {
		$mainbox_bordercol_res="1";
		} else {
		$mainbox_bordercol_res="0";
		}

		// Substitute empty or wrong fields
		
		if ($mainbox_border_res=="0") {
		$mainboxbord="0px solid";
		} 
		
		if ($mainbox_border_style=="1") {
		$mainboxbord="{$mainbox_border_dim}px dotted";
		} 
		
		if ($mainbox_border_style=="2") {
		$mainboxbord="{$mainbox_border_dim}px solid";
		} 
		

		if ($mainbox_bordercol_res=="0") {
		$mainboxbordcol="#ffffff";
		} else {
		$mainboxbordcol=$mainbox_border_color;
		}
		
		$mainboxbgcol=$mainbox_bg_color;


// ---------------------------------------------------------

		$mainbox_width=$mainbox_width."%";
		
		
		// Check Inner Box border style
		
		if ($box_border_style=="0" OR $box_border_style=="1" OR $box_border_style=="2") {
		$box_border_res="1";
		} else {
		$box_border_res="0";
		}

		// Check box border color
		
		if ($box_border_color!=='') {
		$box_bordercol_res="1";
		} else {
		$box_bordercol_res="0";
		}

		
		// Substitute empty or wrong fields
		
		if ($box_border_res=="0") {
		$boxbord="0px solid";
		} 
		
		if ($box_border_style=="1") {
		$boxbord="{$box_border_dim}px dotted";
		} 
		
		if ($box_border_style=="2") {
		$boxbord="{$box_border_dim}px solid";
		} 
		

		if ($box_bordercol_res=="0") {
		$boxbordcol="#ffffff";
		} else {
		$boxbordcol=$box_border_color;
		}
		
		$boxbgcol=$box_bg_color;
		

		// Event Type // Admin choose
		
		if($eventype=="1" || $eventype=="2") {
		$myevent=$eventype;
		} else {
		$myevent="1";
		}
		
		// Event Type // User choose

		if(isset($_POST['userquery'])) { 
		if($_POST['userquery']=="2") {
		$eventuser="2";
		} else {
		$eventuser="1";
		}
		$myevent=$eventuser;
		}

		
		// What time is it baby?
		
		$myday=time();


		// SET EVENT QUERIES

		$query_1= "SELECT p.*, t.*, FROM_UNIXTIME((t.event_datecreated), '%d/%m/%y') as created,
				   FROM_UNIXTIME((t.event_dateupdated), '%H:%i') as updated, FROM_UNIXTIME((t.event_date_start), '%d/%m/%y') as start,
				   FROM_UNIXTIME((t.event_date_end), '%d/%m/%y') as end
				   FROM se_events t LEFT JOIN se_users p ON (t.event_user_id=p.user_id)
				   WHERE t.event_privacy='63' OR t.event_privacy='127'
				   ORDER by ".$choosedate." DESC limit ".$numOfGroup."";

		$query_2= "SELECT p.*, t.*, FROM_UNIXTIME((t.event_datecreated), '%d/%m/%y') as created,
				   FROM_UNIXTIME((t.event_dateupdated), '%H:%i') as updated, FROM_UNIXTIME((t.event_date_start), '%d/%m/%y') as start,
				   FROM_UNIXTIME((t.event_date_end), '%d/%m/%y') as end
				   FROM se_events t LEFT JOIN se_users p ON (t.event_user_id=p.user_id)
				   WHERE t.event_date_start>$myday && t.event_privacy='63' OR t.event_date_start>$myday && t.event_privacy='127'
				   ORDER by ".$choosedate." DESC limit ".$numOfGroup."";
	
	
		if($myevent=="1") {
		$myquery=$query_1;	
		$endtext="Browsing All the Public Events";
		} else if($myevent=="2") {
		$myquery=$query_2;
		$endtext="Browsing Only the Upcoming Events";
		}
	
		
		// Build Full Style Variables
		
		$mystyle="style=\"border:".$boxbord." ".$boxbordcol."; background-color: ".$boxbgcol.";\"";
		$mymainstyle="style=\"border:".$mainboxbord." ".$mainboxbordcol."; background-color: ".$mainboxbgcol.";\"";
		$titlestyle="padding: 0px 5px 5px 0px; border-bottom: 1px solid #CCCCCC; margin-bottom: 5px;";
		$bodystyle="margin-bottom: 5px;";
		$statstyle="font-size: 7pt; color: #777777; font-weight: normal;";


// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					LET'S START QUERY TO RETRIEVE OUR DATA
// ----------------------------------------------------------------------------------------------------------------------------------------------------------


$query=$myquery;

$result = mysql_query($query);

while($row = mysql_fetch_array($result, MYSQL_ASSOC))

{
	

$miovalore= giggitime2($row['event_datecreated'], $num_times=1).' ago';
$miovalore1= giggitime2($row['event_dateupdated'], $num_times=1).' ago, at '.$row['updated'];


// Choose a name or a username...


if ($nametypez=="2") {
$mynome=$row['user_displayname'];
} else {
$mynome=$row['user_username'];
}


// Cut a little bit the group description field...

$mydesc = $row['event_desc'];


// Format the event desc

$mydesc = htmlspecialchars_decode($mydesc, ENT_QUOTES);

if($cut=="0" OR $cut_off=="0" OR $cut_off=="") {
$shortdesc=$mydesc;
} else {
$shortdesc = substr($mydesc,0,$cut_off)."...";
}

if ($hide_desc=="yes") {
$shortdesc="";
}

// Comment-Comments? View-Views? Guest-Guests?

if($row['event_totalcomments']>1) {
$comment="<a href=\"{$socialdir}/event.php?event_id={$row['event_id']}\" title=\"".$go_profile_text.": {$row['event_title']}\"><b>{$row['event_totalcomments']}</b> Comments</a>";
} else 
if($row['event_totalcomments']==1) {
$comment="<a href=\"{$socialdir}/event.php?event_id={$row['event_id']}\" title=\"".$go_profile_text.": {$row['event_title']}\"><b>1</b> Comment</a>";
} else {
$comment="No Comment";
}
if($row['event_views']>1) {
$view="{$row['event_views']} Views";
} else 
if($row['event_views']==1) {
$view="1 View";
} else {
$view="No View";
}
if($row['event_totalmembers']>1) {
$guest="{$row['event_totalmembers']} guests";
} else if($row['event_totalmembers']==1) {
$guest="1 guest";
} else {
$guest="No Guest";
}

$mydir=$wpdir."/wp-content/plugins/wp-se_events";
$subdir = $row['event_id']+999-(($row['event_id']-1)%1000);


if($use_resize !=="no") { // RESIZING SCRIPT

if ($row['event_photo']!='') {
// Creates a thumbnail based on your personal dims (width/height), without stretching the original pic
$mypic="<img src=\"{$mydir}/image.php/{$row['event_photo']}?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/uploads_event/{$subdir}/{$row['event_id']}/{$row['event_photo']}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$mynome."\" />";
} else {
$mypic="<img src=\"{$mydir}/image.php/nophoto.gif?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/{$empty_image_url}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$mynome."\" />";
}

} else { // NO RESIZING SCRIPT

if ($row['event_photo']!='') {
// Creates a thumbnail based on your personal dims (width/height)
$myp=str_replace(".", "_thumb.", $row['event_photo']);
$mypfile=$socialdir."/uploads_event/{$subdir}/{$row['event_id']}/{$myp}";

if (@fopen($mypfile, "r")) {
$myps=str_replace(".", "_thumb.", $row['event_photo']);
$mypfile=$socialdir."/uploads_event/{$subdir}/{$row['event_id']}/{$myps}";
} else {
$mypfile=$socialdir."/uploads_event/{$subdir}/{$row['event_id']}/{$row['event_photo']}";
}

$mypic="<img src=\"{$mypfile}\" width=\"{$mywidth}\" height=\"{$myheight}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$mynome."\" />";
} else {
$mypic="<img src=\"{$socialdir}/{$empty_image_url}\" width=\"{$mywidth}\" height=\"{$myheight}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$mynome."\" />";
}


}


// Create a link to the group

$mylink="<a href=\"".$socialdir."/event.php?event_id=".$row['event_id']."\" title=\"".$go_profile_text.": {$row['event_title']}\">";

// Create a link to the group leader

$mylink1="<a href=\"".$socialdir."/profile.php?user_id=".$row['user_id']."\">";



// Hide or Show the title/body stats

if($row['event_location']=="" and $row['event_host']=="") {
$block1="";
}
if($row['event_location']=="" and $row['event_host']!=="") {
$block1="<div style=\"{$statstyle}\">Guest Star: {$row['event_host']}";
}
if($row['event_location']!=="" and $row['event_host']=="") {
$block1="<div style=\"{$statstyle}\">Location: {$row['event_location']}";
}
if($row['event_location']!=="" and $row['event_host']!=="") {
$block1="<div style=\"{$statstyle}\">Location: {$row['event_location']} - Guest Star: {$row['event_host']}";
}


if ($split=="1") {
$line1="<div style=\"{$statstyle}\">{$guest} - Led by {$mylink1}{$mynome}</a><br />
    Created {$miovalore} - Updated {$miovalore1} | {$comment} and {$view}</div>";
$mystats=$line1;
} else {
$line1="<div style=\"{$statstyle}\">{$guest} - Led by {$mylink1}{$mynome}</a> | Created {$miovalore} - Updated {$miovalore1} | {$comment} and {$view}</div>";
$mystats=$line1;
}


if($shows0=="1") {
$mystats0="
	{$block1} | Event Start: {$row['start']} - Event End: {$row['end']}</div>";
} else {
$mystats0="";
}


if($shows!=="1") {
$mystats="";
}


if($i<$how_many_groups) {

$rows .= "
<td align=\"left\" valign=\"top\">
<table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
<tr>
<td width=\"".$mywidth."\" align=\"left\" valign=\"top\" scope=\"row\">{$mylink}{$mypic}</a></td>
<td align=\"left\" valign=\"top\" scope=\"row\"><div style=\"{$titlestyle}\">{$mylink}{$row['event_title']}</a></div>
{$mystats0}
<div style=\"{$bodystyle}\">{$shortdesc}</div>
{$mystats}
</td>
</tr>
</table>
</td>
";

} else {

$rows .= "
</tr><tr><td align=\"left\" valign=\"top\">
<table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
<tr>
<td width=\"".$mywidth."\" align=\"left\" valign=\"top\" scope=\"row\">{$mylink}{$mypic}</a></td>
<td align=\"left\" valign=\"top\" scope=\"row\"><div style=\"{$titlestyle}\">{$mylink}{$row['event_title']}</a></div>
{$mystats0}
<div style=\"{$bodystyle}\">{$shortdesc}</div>
{$mystats}
</td>
</tr>
</table>
</td>
";

$i=0;
}

$i++;

}

$content .="<table width=\"{$mainbox_width}\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" {$mymainstyle}><tr>";
$content .="{$rows}";

if($user_can_choose=="yes") {
$content .="</tr></table>
<table width=\"100%\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" {$mymainstyle}>
<form action=\"{$here}\" method=\"post\">
<tr>
<td align=\"center\">{$endtext}</td>
</tr>
<tr>
<td>
<div align=\"center\">
<select name=\"userquery\" id=\"userquery\">
<option value=\"\" selected>Event Selector</option>
<option value=\"1\">All Public Events</option>
<option value=\"2\">Upcoming Events</option>
</select>
&nbsp;&nbsp;
<input type=\"submit\" name=\"button\" id=\"button\" value=\"Send\" />
</div>
</td>
</tr>
</form>
</table>";
} else {
$content .="</tr><tr><td align=\"center\">{$endtext}</td></tr></table>";
}

echo $content;


// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					END OF JOOMOOD FUNNY TOY
// ----------------------------------------------------------------------------------------------------------------------------------------------------------

?>