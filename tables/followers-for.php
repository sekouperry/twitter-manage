<?

$my_name = $app->twitter()->screenname();
$results = $db->table("followers")->find(array("owner_account" => $my_name, "found_via" => $_REQUEST["show_followers_for"]));

if(!$results->num_rows()){
	echo "<div class='message'>";
	echo "You are not auto-following followers of " . $_REQUEST["show_followers_for"] . "<br>";
	echo "</div>";
}else{

?>

<table border=1>
	<tr>
		<th width=200>
			Username
		</th>
		<th width=200>
			Followed On
		</th>
		<th width=100>
			Follows Us?
		</th>
		<th width=100>
			Un-Followed
		</th>
		<th width=40>
			[Un]follow
		</th>
	</tr>

<?
	
while($row = $results->fetch_array()){
	echo "<tr>";
	echo "<td>" . htmlspecialchars($row["screen_name"]) . "</td>";
	echo "<td>" . htmlspecialchars($row["auto_followed_on"]) . "</td>";
	echo "<td>" . htmlspecialchars($row["is_following_us"] ? "Yes" : "No") . "</td>";
	echo "<td>" . htmlspecialchars($row["un_followed_on"]) . "</td>";
	echo "<td>";
	echo "<form action='" . page_self_url() . "' method=post>";
	if($row["is_following_them"]){
		echo "<input type='hidden' name=unfollow value=" . $row["screen_name"] . ">";
		echo "<input type='submit' value='unfollow'>";
	}else{
		echo "<input type='hidden' name=follow value=" . $row["screen_name"] . ">";
		echo "<input type='submit' value='follow'>";
	}
	echo "</form>";
	echo "</td>";
	echo "</tr>";
}
?>


	<tr>
		<td colspan=5>
			<form action="<?=page_self_url()?>" method=POST>
				Auto follow <input type='text' name='autofollow'>'s followers
				<input type='submit'>
			</form>
		</td>
	</tr>

</table>


<?

}

?>