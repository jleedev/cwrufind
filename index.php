<?php
$filter = array();
$tags = array("uid","email","name","first","middle","last","telephone","shell","department","title","postal","physical");
$ldaptotag = array(
	"uid" => "uid",
	"mailEquivalentAddress" => "email",
	"mailAlternateAddress" => "email",
	"displayName" => "name",
	"givenName" => "first",
	"initials" => "middle",
	"sn" => "last",
	"telephoneNumber" => "telephone",
	"loginShell" => "shell",
	"ou" => "department",
	"title" => "title",
	"postalAddress" => "postal",
	"physicalDeliveryOfficeName" => "physical"
);
$tagtoldap = array(
	"email" => "email",
	"uid" => "uid",
	"name" => "displayName",
	"first" => "givenName",
	"middle" => "initials",
	"last" => "sn",
	"telephone" => "telephoneNumber",
	"shell" => "loginShell",
	"department" => "ou",
	"title" => "title",
	"postal" => "postalAddress",
	"physical" => "physicalDeliveryOfficeName"
);
foreach($tags as $tag)
	if(isset($_GET[$tag]) && $_GET[$tag] !== "")
		$filter[$tagtoldap[$tag]] = $_GET[$tag];
$results = array();
$results2 = array();
$multi = false;
$request = "";
$request2 = "";
$b = false;
foreach($filter as $key => $value) {
	if($b) {
		$request .= "\" \"";
		$request2 .= "\" \"";
	}
	$b = true;
	$value2 = $value;
	$key2 = $key;
	if($key === "email") {
		$multi = true;
		$index = strrpos($value,"@");
		if($index) {
			$post = substr($value,$index+1);
			if($post === "case.edu" || $post === "cwru.edu") {
				$value2 = substr($value,0,$index);
				$value = $value2 . "@cwru.edu";
				$value2 .= "@case.edu";
			}
		} else {
			$value2 = $value . "@case.edu";
			$value .= "@cwru.edu";
		}
		$key = "mailEquivalentAddress";
		$key2 = "mailAlternateAddress";
	}
	$request .= "$key=".substr(escapeshellarg($value), 1, -1);
	$request2 .= "$key2=".substr(escapeshellarg($value), 1, -1);
}
$request .= "\"";
$request2 .= "\"";
/*foreach($ldaptotag as $tag => $foobar) {
	$request .= " $tag";
	$request2 .= " $tag";
}*/
if(count($filter) > 0) {
	exec("ldapsearch -h ldap.case.edu -xLLLb ou=People,o=cwru.edu,o=isp \"$request",$results,$b);
	if(multi) exec("ldapsearch -h ldap.case.edu -xLLLb ou=People,o=cwru.edu,o=isp \"$request2",$results2,$b);
}
/*print("<pre>");
print($request);
print("</pre>");*/

$submit = array(
	"EXPAND YOUR MIND",
	"GET TO IT NOW",
	"FROB THIS, BABY",
	"LEARN THE TRUTH&#153",
	"GIVE ME THE LOWDOWN",
	"HAVE FAITH IN THE WAYS OF THE LDAP",
	"LET IT ALL OUT",
	"BROADEN YOUR HORIZONS",
	"LIBERATE THE LDAPIANS",
	"SHED YOUR INHIBITIONS",
	"MAKE YOUR MOVE",
	"GIVE IT TO ME SLOWLY",
	"I'M FEELING LUCKY!",
	"MAKE IT SO",
	"JUST TELL ME ALREADY",
	"TAKE THE PLUNGE",
	"TO FIND, SEARCH YOU MUST",
	"I'M NOT A STALKER, I SWEAR!",
	"BE ADVENTUROUS!",
	"COULD I GET SOME FRIES WITH THAT?",
	"LEARN SOMETHING NEW"
);
$title = array(
	"blah blah blah blah something",
	"[insert generic title here]",
	"showing up those FPB L4M3Rz as a way of life",
	"because public information is sexy",
	"even better than the Nord Lab camera!",
	"is sort of like syntactic sugar for ldapsearch",
	"finder? I barely knew her!",
	"brought to you by the Nord Lab floor fairies",
	"for Case kids, by Case kids, all about Case kids",
	"because CWRU POO is unfunny",
	"serving the dread Shub Internet since January 1st, 1970",
	"because it's good to have friends who don't know they're friends",
	"because information should be free",
	"oh god, the SASL, it burns!",
	"...title? Titles are for books. This is the INTERNET! (who reads books, anyway?)",
	"PAM cooking spray, now with LDAP!",
);
$learn = array("learn","grok","dig up","excavate","inspect","collect");
$shit = array("shit","stuff","information","details","crap","knowledge","stalkery bits");
$about = array("about","concerning","pertaining to","attached to");
$dudeordudette = array("dude or dudette","kid","affiliate","groupie");
$stuff = array("stuff","guys","shit","information","crap","alphanumerics","unicode","ascii","foobar","qualifiers");
$guys = array("guys","fields","thingys","blanks","boxes","boxen");
$narrowdown = array("narrow down","reduce the complexity of","trim down","reduce the cardinality of");
$search = array("search","solution set","results");

$title = $title[rand(0,count($title)-1)];
$learn = $learn[rand(0,count($learn)-1)];
$shit = $shit[rand(0,count($shit)-1)];
$about = $about[rand(0,count($about)-1)];
$dudeordudette = $dudeordudette[rand(0,count($dudeordudette)-1)];
$stuff = $stuff[rand(0,count($stuff)-1)];
$guys = $guys[rand(0,count($guys)-1)];
$narrowdown = $narrowdown[rand(0,count($narrowdown)-1)];
$search = $search[rand(0,count($search)-1)];
$submit = $submit[rand(0,count($submit)-1)];

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>CWRU FIND - <?php
echo $title;
?></title>
</head><body>
	<center>
<?php
echo "\t\tTo $learn some $shit $about some Case $dudeordudette, put some $stuff in the $guys to $narrowdown the $search.";
?>
		<br />
		<br />
		<form name="fooform" method="get">
			<table border="0">
				<tr>
					<td>
						Case Network ID
					</td><td width="15" /><td>
						<input name="uid" type="text" <?php if(isset($_GET['uid'])) print "value=\"{$_GET['uid']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Email Address
					</td><td width="15" /><td>
						<input name="email" type="text" <?php if(isset($_GET['email'])) print "value=\"{$_GET['email']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Entire Name
					</td><td width="15" /><td>
						<input name="name" type="text" <?php if(isset($_GET['name'])) print "value=\"{$_GET['name']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						First Name
					</td><td width="15" /><td>
						<input name="first" type="text" <?php if(isset($_GET['first'])) print "value=\"{$_GET['first']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Middle Initial
					</td><td width="15" /><td>
						<input name="middle" type="text" <?php if(isset($_GET['middle'])) print "value=\"{$_GET['middle']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Last Name
					</td><td width="15" /><td>
						<input name="last" type="text" <?php if(isset($_GET['last'])) print "value=\"{$_GET['last']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Telephone Number
					</td><td width="15" /><td>
						<input name="telephone" type="text" <?php if(isset($_GET['telephone'])) print "value=\"{$_GET['telephone']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						UNIX Shell
					</td><td width="15" /><td>
						<input name="shell" type="text" <?php if(isset($_GET['shell'])) print "value=\"{$_GET['shell']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Department
					</td><td width="15" /><td>
						<input name="department" type="text" <?php if(isset($_GET['department'])) print "value=\"{$_GET['department']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Title
					</td><td width="15" /><td>
						<input name="title" type="text" <?php if(isset($_GET['title'])) print "value=\"{$_GET['title']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Postal Address
					</td><td width="15" /><td>
						<input name="postal" type="text" <?php if(isset($_GET['postal'])) print "value=\"{$_GET['postal']}\" "; ?>/>
					</td>
				</tr><tr>
					<td>
						Physical Delivery Address
					</td><td width="15" /><td>
						<input name="physical" type="text" <?php if(isset($_GET['physical'])) print "value=\"{$_GET['physical']}\" "; ?>/>
					</td>
				</tr>
			</table>
			<br />
<?php
echo "\t\t<input type=\"submit\" value=\"$submit\" />\n";
?>		</form>
<?php
print "<br /><br /><table cellspacing=\"10\">";
$display = array();
$display['email'] = array();
$dns = array();
$multir = array($results,$results2);
if(!$multi) $multir = array($results);
foreach($multir as $r) {
	foreach($r as $result) {
		if($result === "") {
			if(!in_array($display['uid'],$dns)) {
				print "<tr><th colspan=\"3\">{$display['name']}</th></tr>";
				if(isset($display['uid']))
					print "<tr><td align=\"right\">Case Network ID:</td><td width=\"15\" /><td>{$display['uid']}</td>";
				print "<tr><td align=\"right\">Email Addresses:</td><td width=\"15\" /><td>";
				foreach($display['email'] as $email)
					print "$email<br />";
				print "</td>";
				if(isset($display['middle']))
					print "<tr><td align=\"right\">Middle Initial:</td><td width=\"15\" /><td>{$display['middle']}</td>";
				if(isset($display['telephone']))
					print "<tr><td align=\"right\">Telephone Number:</td><td width=\"15\" /><td>{$display['telephone']}</td>";
				if(isset($display['shell']))
					print "<tr><td align=\"right\">UNIX Shell:</td><td width=\"15\" /><td>{$display['shell']}</td>";
				if(isset($display['department']))
					print "<tr><td align=\"right\">Department:</td><td width=\"15\" /><td>{$display['department']}</td>";
				if(isset($display['title']))
					print "<tr><td align=\"right\">Title:</td><td width=\"15\" /><td>{$display['title']}</td>";
				if(isset($display['postal']))
					print "<tr><td align=\"right\">Postal Address:</td><td width=\"15\" /><td>{$display['postal']}</td>";
				if(isset($display['physical']))
					print "<tr><td align=\"right\">Physical Address:</td><td width=\"15\" /><td>{$display['physical']}</td>";
				print "<tr /><tr />";
				$dns[] = $display['uid'];
			}
			unset($display);
			$display = array();
			$display['email'] = array();
		} else {
			$value = strstr($result,": ");
			$key = substr($result,0,strlen($result)-strlen($value));
			$value = substr($value,2);
			if(!in_array($key,array_keys($ldaptotag))) continue;
			$key = $ldaptotag[$key];
			if($key === "email") {
				$display['email'][] = $value;
			} else {
				$display[$key] = $value;
			}
		}
	}
}
print "</table>";
?>
	</center>
</body>
</html>
