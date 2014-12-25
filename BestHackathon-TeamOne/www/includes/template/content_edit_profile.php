<?php
require_once ("php/config.php");
?>
<script type="text/javascript">
	var itemsOnScreen = 1;
	function taskBlockResize(number){
        $('div.addformwithbutton').fadeIn(0);
        $('div.task_add_button').fadeOut(0);
        

    }
    $(document).ready(function() {
    	$('div.addformwithbutton').fadeOut(0);


	    $( 'button#refreshinfo' ).click(function() {
	    	var sendData = "fname="+$('#fname').val()+"&lname="+$('#lname').val();
            $.ajax({
                type: "POST",
                url: "/edit_profile2.php",
                data: sendData,
                success: function(returnD) {
                		location.reload();
                }
            });

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
				<?php require 'php/config.php'; ?>
		<div class="container_menu">
			<main class="content">
					<form>
						First name: <br><input type="text" id="fname" name="fname" value=<?php echo '"'.$_SESSION['name'].'"';?>><br>
						Last name:<br><input type="text" id="lname" name="lname" value=<?php echo '"'.$_SESSION['surname'].'"';?>><br>
						Birthday:<br>
						 <select style="width:100px;">
						  <option value="January">January</option>
						  <option value="Fabruary">Fabruary</option>
						  <option value="March">March</option>
						  <option value="April">April</option>
						  <option value="January">May</option>
						  <option value="Fabruary">June</option>
						  <option value="March">July</option>
						  <option value="April">August</option>
						  <option value="January">September</option>
						  <option value="Fabruary">October</option>
						  <option value="March">November</option>
						  <option value="April">December</option>
						</select> 
						<select style="width:60px;">
						  <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option>
						</select> 
						<input type="text" style="width:100px;">
						<br>
						<button id="refreshinfo">Submit</button>
					</form>				
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