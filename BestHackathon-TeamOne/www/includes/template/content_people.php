<script type="text/javascript">
	var itemsOnScreen = 1;
	function taskBlockResize(number){
        $('div.addformwithbutton').fadeIn(0);
        $('div.task_add_button').fadeOut(0);
        

    }
    $(document).ready(function() {
    	$('div.addformwithbutton').fadeOut(0);


	    $( 'button#addtaskbutton' ).click(function() {

		});	



	});
		    function onCheckItemKeyUp(event){
		    if(event.keyCode == 13 && $("input#checkItemId"+itemsOnScreen.toString()).val()!=""){
		    	//alert("hellp");
		    	itemsOnScreen++;
		        $("div#addform").append("<input id=\"checkItemId"+itemsOnScreen+"\" class=\"checkItem\" onkeyup=\"onCheckItemKeyUp(event)\"><br>");
		        $("input#checkItemId"+itemsOnScreen.toString()).focus();
		    }
	    }

</script>
	<div class="middle">
				
		<div class="container_menu">
			<main class="content">
				<table border="1">
					<tr><td colspan="1">Name</td><td>Points</td></tr>
					<?php 
					require 'php/config.php'; 
						$rez = mysql_query("SELECT * FROM users");
						while($r = mysql_fetch_array($rez)) {
							if($r['name']!="" && $r['surname']!=""){
					?>
					<tr>
					<td><a href="/user.php?id=<?php echo $r['id'];?>">
					<?php 
						echo $r['name']." "; 
						echo $r['surname']; 
					?>
					</a></td>
					<td>
					<?php echo $r['points']; ?>
					</td>
					</tr>
					<?php
						}}
					?>
				</table>
				
			</main><!-- .content -->
		</div><!-- .container-->
<?php $id = $_SESSION['id']; ?>
<aside class="left-sidebar"><br>
			<div class="sidebar_me"><div class="sidebar_me_ava" style='background-image: url("http://api.adorable.io/avatars/<?php echo $id; ?>");'></div><div class="sidebar_me_name">
			<?php 
				
				$sql = "SELECT * FROM users 
					WHERE id = '" . $id . "' LIMIT 1";
				$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
				$row = mysql_fetch_assoc($query);
				echo $row['name']." ".$row['surname'];
			?>

			</div></div><hr>
			<a href="/edit_profile.php"><div class="sidebar_item"><div class="sidebar_item_icon"></div><div class="sidebar_item_name">Edit profile</div></div></a><hr>
			<a href="/user.php"><div class="sidebar_item"><div class="sidebar_item_icon"></div><div class="sidebar_item_name">My Aims</div></div></a><hr>
			
			<a href="#"><div class="sidebar_item"><div class="sidebar_item_icon"></div><div class="sidebar_item_name">Followers</div></div></a><hr>
			<a href="#"><div class="sidebar_item"><div class="sidebar_item_icon"></div><div class="sidebar_item_name">Followings</div></div></a><hr>

			<a href="/people.php"><div class="sidebar_item"><div class="sidebar_item_icon"></div><div class="sidebar_item_name">Leadership board</div></div></a><hr>
			<a href="/" onclick='$.ajax({
			    type: "POST",
			    url: "/php/login.php?action=logout",
			    data: "",
			    success: function(html){
			        window.location.href = "http://best.udesgo.com";
			    }
			    });'><div class="sidebar_item"><div class="sidebar_item_icon"></div><div class="sidebar_item_name">Log out</div></div></a><hr>

		</aside><!-- .left-sidebar -->

	</div>