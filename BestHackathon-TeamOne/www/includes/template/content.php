<?php
require_once("php/config.php");
?>
<script type="text/javascript">
	var itemsOnScreen = 1;
	var myId = <?php echo $_SESSION['id'];?>;
	var hisId = <?php 
	if(isset($_GET['id']))
		echo $_GET['id'];
	else
		echo $_SESSION['id'];
	?>;
	function taskBlockResize(number){
        $('div.addformwithbutton').fadeIn(0);
        $('div.task_add_button').fadeOut(0);
    }



    $(document).ready(function() {
		$( 'button#follow' ).click(function() {
			var sendData = "myid="+ myId.toString()+"&hisid="+hisId.toString();
			$.ajax({
                type: "POST",
                url: "/php/follow.php",
                data: sendData,
                success: function(returnD) {
                	alert(returnD);
                }
            });
		});	

    	$('div#wait').fadeOut(0);
    	$('div.addformwithbutton').fadeOut(0);




	    $( 'button#addtaskbutton' ).click(function() {	
            $('div#wait').fadeIn(0);
            if($('#newtasktitle').val()=="" || $('#newtasktitle').val()==" "){
            	alert("Title is required!");
            	$('div#wait').fadeOut(0);
            	return;
            }
            var sendData = "title="+$('#newtasktitle').val()+"&description="+$('#newtaskdescription').val();
            
            for (var i = 1; i <= itemsOnScreen; i++) {
            	sendData+="&checkitem"+i.toString()+"="+$('#checkItemId'+i.toString()).val();
            };
          
            $.ajax({
                type: "POST",
                url: "/php/addmytask.php",
                data: sendData,
                success: function(returnD) {
                	if(returnD!=false){
                		$('div#wait').fadeOut(0);
                		location.reload();
                	}
                }
            });
		});	



	});
		    function onCheckItemKeyUp(event){
		    if(event.keyCode == 13 && $("input#checkItemId"+itemsOnScreen.toString()).val()!=""){
		    	itemsOnScreen++;
		        $("div#addform").append("<input type=\"text\" id=\"checkItemId"+itemsOnScreen+"\" class=\"checkItem\" onkeyup=\"onCheckItemKeyUp(event)\"><br>");
		        $("input#checkItemId"+itemsOnScreen.toString()).focus();
		    }
	    }




</script>

<?php
require_once ("php/config.php");
$id = $_SESSION['id'];
if(isset($_GET['id']))
	$id = $_GET['id'];
?>
	<div class="middle">
				
		<div class="container_menu">
			<main class="content">

			<div class="tasks">
				<?php
					include "php/getalltasks.php";
				?>
				<?php 
				if($id == $_SESSION['id']){
				?>

				<div id="task00" class="task_add" onclick='taskBlockResize("00")'>
					<div class="task_add_button"><img src="img/add_aim2.png" width="100%"></div>
						<div class="addformwithbutton">
							<div id="addform">
								Title:<br><input type="text" id="newtasktitle" name="title"><br>
								Description:<br><textarea type="text" id="newtaskdescription" name="description"></textarea><br>
								Checklist:<br>
								<input type="text" id="checkItemId1" class="checkItem" onkeyup="onCheckItemKeyUp(event)"><br>

							</div>
						<button id="canceladdtaskbutton" onclick="location.reload();">Cancel</button>
						<button id="addtaskbutton" style="background-color:#127821;">ADD</button>
						<div id="wait"><img src="img/wait.gif"></div>
						</div>
					
				</div>
				<?php } else{?><button id="follow">FOLLOW</button><br><?php }?>
			</div>
			</main><!-- .content -->
		</div><!-- .container-->

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