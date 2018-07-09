<div class="panel">
	<div class="panel-collapse collapse in">
		<div class="panel-body">
			<div class="row">
				<!-- Example Basic -->
					<?php if(!empty($task)):?>
		<div class="example-wrap">
			<div class="example table-responsive">
				
				<table class="table">
					<thead>
						<tr>
							<th class="text-center">#</th>
<!--
							<th class="text-center">Task</th>
-->
							<th class="text-center">Title</th>
							<th class="text-center">Price</th>
							<th class="text-center">Payment Status</th>
							<th class="text-center">Task Status</th>
<!--
							<th class="text-center">Submitted Task</th>
-->
							<th class="text-center">Action</th>
						
						</tr>
					</thead>
					<tbody>
					<?php $sn=1; foreach ($task as $s=> $task) {
						$upl="";
						if(!empty($task->uploadTask)):
						$upl = base_url()."../uploads/task/".$task->uploadTask;
						endif;
						
						?>
					
						<tr>
							<td class="text-center"><?php echo $sn; ?></td>
<!--
							<td class="text-center"><a target="_blank" href="<?php echo base_url().'../uploads/task/'.$task->taskFile ;?>">
			<img  src="<?php echo base_url().ADMIN_THEME;?>assets/images/aishwary.png"  style="max-height:50px; max-width:50px"/>   
			</a></td>
-->
							<td class="text-center"><?php echo $task->title; ?></td>
							<td class="text-center"><i class="fa fa-usd" aria-hidden="true"></i><?php echo $task->price; ?></td>
							<td class="text-center"> <span  class="label label-<?php echo $task->paymentStatus ? 'success':'danger'; ?>"><?php echo $task->paymentStatus ? 'Complete':'Incomplete'; ?></span></td>
							<td class="text-center"><span  class="label label-<?php echo $task->workStatus ? 'info':'warning'; ?>"><?php echo $task->workStatus ? 'Submitted':'Not submitted'; ?></span></td>	
<!--
							<td class="text-center"><a href="<?php echo !empty($upl)? $upl:'javascript:void(0);'; ?>"  <?php echo !empty($upl)? "target='_blank'" :""; ?> class="btn btn-icon btn-dark">
										Uploads
									</a> </td>	
-->
							<td class="text-center"><a href="<?php echo base_url().'prospect/taskDetail/'.$task->id; ?>" class="btn btn-icon btn-info btn-outline btn-round"  title="More Details">
										<i class="icon wb-eye" aria-hidden="true"></i>
									</a> </td>	
						</tr>
						<?php $sn++; } ?>
					</tbody>
					<fbody>
						<tr>
							<td colspan="6"></td>
						</tr>
					</fbody>
				</table>
				
			</div>
		</div>
		<?php endif; if(empty($task)):?>
				<center style=color:red;font-size:20px;>No record available for Task.</center> 
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
