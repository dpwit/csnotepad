
<?php 		


$getContent = "SELECT * FROM news  WHERE status= '1' ORDER BY uid DESC ";
		$pageinfo = mysql_query($getContent);
			
			if (!$pageinfo) {
			
			  die ('I cannot connect to get the paginfo as: ' . mysql_error()); 
			  error('A database error occurred  ');
		      }
			  
?>

<!-- LOOP THROUGH NEWS ITEMS -->
			
			<?php while ($row = mysql_fetch_array($pageinfo, MYSQL_BOTH)) {  
			
			$content =  $row['shorttext'];
			//$sentance = explode(".", $content);
				
			?>
			<div style=" margin-bottom:5px;">
			
				
			<div >
			<div style="float:left;">	
			<a href="newsView.php?title=<?php echo $row['title'];?>&amp;newsItem=<?php echo $row['uid'];?> " >
			<img src="images/news/thumbs/<?php echo $row['image'];?>" style="border:5px solid #CCCCCC;" alt=" <?php echo $row['title'];?> "  /> 
			</a>
			</div>
			
			<div style="float:left; ">
			<h2 style ="font-size:14px; margin-bottom:0px; padding-bottom:0px; margin-left:20px; color:#b4b4b4" > <?php echo $row['title'];?>  </h2><br/>
			<?php echo $content; ?> <br/>
			<a href="newsView.php?title=<?php echo $row['title'];?>&amp;newsItem=<?php echo $row['uid'];?> " > <b>..More </b></a> 
			
			</div>
			<div style="clear:both"> &nbsp;	</div>
			
			</div>
			
			</div>
			
			<?php  }
					
		mysql_free_result($pageinfo);
					
?> 


