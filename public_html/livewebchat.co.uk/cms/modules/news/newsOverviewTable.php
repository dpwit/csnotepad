	<!-- do the query -->
								
	<?Php
								
	//include_once 'db_cms.php';
					
	dbConnect();
									
	$result = mysql_query($sql_list );
								
	if (!$result) {
								
	 die (' (Line 17) I cannot connect to the database because : ' . mysql_error()); 
								
	error('A database error occurred  ');
	}
								
  ?>
			
<!-- return the results -->
								
								
<table class="cmstable" cellpadding="0" cellspacing="0" width="700" style="">
					
<tr >
<td width="97"  align="center"  class="tablecell"> <p>Action</p></td>
<td width="53" align="center"  class="tablecell" > <p>Title</p></td>
<td width="166" align="center"  class="tablecell" ><p>Content</p> </td> 
<td width="123" align="center"  class="tablecell" ><p>Status </p></td> 
</tr>
										
<?php 
while ($row = mysql_fetch_array($result, MYSQL_BOTH)) { ?> 
<tr>
<td align="center" class="tablecellLeft" s>
 <a style="color:#ff0000; font-size:12px; font-weight:bold; " href="editItem.php?pageType=<?php echo $pageType;?>&cms_uid=<?php echo $row[0] ?>"> Edit Item</a> <br/>
 <a style="color:#ff0000; font-size:12px; font-weight:bold; " href="deleteItem.php?pageType=<?php echo $pageType;?>&cms_uid=<?php echo $row[0] ?>"> Delete Item</a> <br/>
 </td>
 <td align="center" class="tablecell"> <p><?php echo $row["title"]; ?></p> </td>
 <td align="center" class="tablecell"> <p><?php echo substr($row["content"], 0, 100); ?></p>  </td>
 <td align="center" class="tablecell"> <p class="statusText">
 <?php if ( $row["status"]==1) {
 echo "Active"; }
 else {echo "Inactive";} ; ?> &nbsp; </p> </td>
 </tr>
 <?php }
										
 mysql_free_result($result);
 ?> 
							
 </table>
					
 </div>

 </div>
			 
			
 <!-- End of Body -->