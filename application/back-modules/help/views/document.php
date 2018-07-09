<div class="documents-wrap articles">
	<ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-xs-2" data-plugin="matchHeight">
		<?php  foreach ($task as $s=> $task) : if(!empty($task->uploadTask)):
			$upl = base_url()."../uploads/task/".$task->uploadTask;
		 ?>
	  <li>
		<div class="articles-item">
		  <i class="icon wb-file" aria-hidden="true"></i>
		  <h4 class="title"><a href="javascript:void(0);"><?php echo $task->title; ?></a> <span  class="label label-<?php echo $task->workStatus ? 'info':'warning'; ?>"><?php if($task->workStatus==1){
			  echo 'Submitted';
			  }else if($task->workStatus==2){ echo "Approved";}else if($task->workStatus==3){ echo "Not Approved";}else{'Not submitted';} ?></span></h4>
			<p><a href="<?php echo !empty($upl)? $upl:'javascript:void(0);'; ?>"  <?php echo !empty($upl)? "target='_blank'" :""; ?> class="">
										View Document
									</a> </p>
									 <hr>
		</div>
	  </li>
	  <?php endif; endforeach; ?>
	</ul>
	<?php  if(empty($task)):?>
			<center style=color:red;font-size:20px;>No record available for Document.</center> 
	<?php endif; ?>
</div>
