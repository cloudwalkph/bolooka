<style type="text/css">
body { font-family:verdhana; font-size: 12px; text-align: center; }
#main_portion{  text-align: left; padding:0; float: left;}
#public { width:95%; border-bottom:3px dotted #ccc; height:137px;  padding:10px; }
.members{ cursor: pointer;width:180px; position: relative; float: left; border:1px dotted #ccc; text-align: left; padding:3px;font-size: 14px; margin-top: 3px; margin-left: 3px;z-index:999;}
.members img{ padding:2px; border:1px solid #ccc; float:left;}
#groupsall{ clear:both; width:100%; height:auto; padding:10px; padding-left: 0px; margin-top: 5px; }
.group{ float:left; position:relative; width:250px; border:1px solid #ccc; padding:3px; margin-left: 9px; text-align: left; min-height:70px; height:auto; background-color:#f5f5f5; z-index:0;}
.group ul{ padding:0; margin:0;}
.group li { float:left; list-style: none; padding:2px;}
.add{ position: absolute; z-index:99;}
.remove{ position: absolute; z-index:99;}
h2{ text-align: left;}
h1{ font-family: 'Love Ya Like A Sister', cursive; color: #cc0000; font-size: 40px;}
h4{ font-family: 'Love Ya Like A Sister', cursive; }
</style> 
<script type="text/javascript" >
	var $gallery = $(".members");
		$( "img", $gallery ).mouseenter(function(){
			 var $this = $(this);
			 
			 $this.css('cursor', 'move');
			  $this.draggable({
				helper: "clone"
			 }); 
			 /*  if(!$this.is(':data(draggable)')) {
			    $this.draggable({
			     	helper: "clone",
					containment: $( "#demo-frame" ).length ? "#demo-frame" : "document", 
					cursor: "move"
			    });
			  } */
		});
		
		$(".group").livequery(function(){
			var casePublic = false;
			$(this).droppable({
				drop: function( event, ui ) {
					var m_id = $(ui.draggable).attr('rel');
					if(!m_id)
					{
						casePublic = true;
						var m_id = $(ui.draggable).attr("id");
						m_id = parseInt(m_id.substring(3));
					}	
					var g_id = $(this).attr('id');
				
						$( this )
							.addClass( "ui-state-highlight" );
							dropPublic(m_id, g_id, casePublic);
							$("#mem"+m_id).hide();
							$( "<li></li>" ).html( ui.draggable ).appendTo( this );
					var dataString = 'm_id=' + m_id + '&g_id=' + g_id;
					$.ajax({
						type: "POST",
						url: "../dashboard/groups/",
						data: dataString,
						cache: false,
						success: function()
						{
							
						}
					});
					
				}
				
				
			}); 
			
			
			/* $(this).droppable({
				activeClass: "ui-state-highlight",
				drop: function( event, ui ) {
					var m_id = $(ui.draggable).attr('rel');
					if(!m_id)
						{
							casePublic = true;
							var m_id = $(ui.draggable).attr("id");
							m_id = parseInt(m_id.substring(3));
						}					
					var g_id = $(this).attr('id');
					dropPublic(m_id, g_id, casePublic);
					//alert(g_id);
					$("#mem"+m_id).hide();
					$( "<li></li>" ).html( ui.draggable ).appendTo( this );
				},
				 out: function(event, ui) {
				 	var m_id = $(ui.draggable).attr('rel');
					var g_id = $(this).attr('id');			 	
				 	$(ui.draggable).hide("explode", 1000);
				 	removeMember(g_id,m_id);
				 }
			}); */
		});
		
		function dropPublic(m_id, g_id, casePublic)
		{
			$("#added"+g_id).animate({"opacity" : "10" },10);
			$("#added"+g_id).show();
			$("#added"+g_id).animate({"margin-top": "-50px"}, 450);
			$("#added"+g_id).animate({"margin-top": "0px","opacity" : "0" }, 450);
		}
		
		function removeMember(g_id,m_id)
		{
			$("#removed"+g_id).animate({"opacity" : "10" },10);
			$("#removed"+g_id).show();
			$("#removed"+g_id).animate({"margin-top": "-50px"}, 450);
			$("#removed"+g_id).animate({"margin-top": "0px","opacity" : "0" }, 450);
		}
		
</script>


<div id="main_portion">
	<div id="public">
	<h2>Websites</h2>
	<!-- Initiate members -->
		<?php

		if(!isset($members))
			$members = $this->group_model->public_website();
			
			if($members)
				{
					//print_r($members); 
					
					foreach($members as $member)
					{
						$web_id = $member['id'];
						$webname = $member['site_name'];
						
						
						$query2 = $this->db->query("SELECT * FROM logo WHERE website_id='$web_id' ORDER BY website_id LIMIT 1");
						if($query2->num_rows() > 0)
						{
							foreach($query2->result_array() as $rows)
							{
								$mylogo = $rows['image'];
							}
							
							
						}
						else
						{
							$mylogo = 'img/Default Profile Picture.jpg';
						}
						echo "<div class='members' id='mem".$web_id."'>\n";
						echo "<img width='25px' height='25px' src='".base_url().$mylogo."' rel='".$web_id."'>\n";
						echo "<b>".ucwords($webname)."</b>\n";
						echo '<span></span>';
						echo "</div>";
												
					} 
				}
			else
				echo "<h2><center>Members not available</center></h2>";
		?>
	</div>
	<div id="groupsall">
	<!-- Initiate Groups -->
	<h2>Groups</h2>
		<?php
			if(!isset($groups))
				$groups = $this->group_model->groups();
			if($groups)
				{
					//print_r($groups);
					foreach($groups as $group)
						{
							extract($group);
							echo "<div style='margin-top:15px;' id='".$id."' class='group'>\n";
							echo ucwords($group_name);
							echo "<div id='added".$id."' class='add' style='display:none;float:left;margin-left:-20px;' ><img src='".base_url()."img/green.jpg' width='25' height='25'></div>";
							echo "<div id='removed".$id."' class='remove' style='display:none;float:left;margin-left:-20px;' ><img src='".base_url()."img/red.jpg' width='25' height='25'></div>";
							echo "<ul>\n";
							echo $this->group_model->updateGroups($id);
							echo "</ul>\n";
							echo "</div>";								
						}
				}
		?>
	</div>
</div>