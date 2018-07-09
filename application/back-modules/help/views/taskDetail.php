<div class="page-main">
	<div class="page-header">
		<h1 class="page-title">Task Detail</h1>
		<div class="page-header-actions">
			<?php $userId = $task['userId']; ?>
        <a  href="<?php echo base_url()."prospect/prospectList/".$userId."?section=task" ?>" class="btn btn-sm btn-info btn-outline btn-round">
          <i aria-hidden="true" class="icon wb-reply"></i>
          <span class="hidden-xs">Back</span>
        </a>
      </div>
	</div>
  	<div class="page-content">
		<?php 
					//~ echo "<pre>";
					//~ print_r($task);
					//~ echo"</pre>";
				$user = $task['user']['userDetail'];
				$fullName = !empty($user['fullName']) ? $user['fullName']:'';
				$profileImage = !empty($user['profileImage']) ? $user['profileImage']:'';
				$taskId = $task['id'];
				
				$price = $task['price'];
				$paymentStatus = $task['paymentStatus'];
				$workStatus = $task['workStatus'];
				$taskFile = $task['taskFile'];
				$uploadTask = $task['uploadTask'];
				$upd = $task['upd'];
				$crd = $task['crd'];
				$title = $task['title'];
				$document= base_url().ADMIN_THEME."global/photos/placeholder.png";
				$document1= base_url().ADMIN_THEME."global/photos/placeholder.png";
				$upl="";
				$upl1="";
				if(!empty($uploadTask)):
				$upl = base_url()."../uploads/task/".$uploadTask;
				$document = base_url()."../uploads/task/".$uploadTask;
				endif;
			
				if(!empty($taskFile)):
				$upl1 = base_url()."../uploads/task/".$taskFile;
				$document1 = base_url()."../uploads/task/".$taskFile;
				endif;
				
				?>
				
			<?php if($this->session->flashdata('success') != null) : ?>
				<div class="alert dark alert-icon alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class="icon wb-check" aria-hidden="true"></i> <?php echo $this->session->flashdata('success'); ?> 
				</div>   
			<?php endif; ?>
    	<div class="panel">
          	<div class="panel-heading">
            	<h3 class="panel-title">Task</h3>
            		
          	</div>
          	<div class="panel-body">
				
<!--
          task
-->

			  <div class="projects-wrap">
				  
				<div class="row">
					<div class=" col-md-12 pull-right text-right">

					<?php if($workStatus==1){?>
					<a href="<?php echo base_url().'prospect/taskApproved/2/'.$taskId.'/'.$userId; ?>" class="btn btn-primary">Approve</a>
					<a href="<?php echo base_url().'prospect/taskApproved/3/'.$taskId.'/'.$userId; ?>"class="btn btn-danger">Not Approve</a>

					<?php }elseif($workStatus==2){ 
					echo "<center style=color:red;font-size:20px;>Approved.</center>";
					}elseif($workStatus==3){ 
					echo "<center style=color:red;font-size:20px;> Not Approved Elegility Questionnaire.</center>";

					}
					?>
					</div>
				</div>
				 <div class="row">
						<div class="col-md-4">
							<div class="example-wrap">
							<h4 class="example-title"><?php echo $title; ?></h4>
							
							<ul class="list-group">
							<li class="list-group-item">
								Name <span class="label label-success pull-right"><?php echo $fullName; ?></span>
							</li>
							
							<li class="list-group-item">
								Title<span class="label label-success pull-right"><?php echo $title; ?></span>
							</li>
							
							<li class="list-group-item">
								Price<span class="label label-success pull-right"><?php echo '$'.$price; ?></span>
							</li>
							
							<li class="list-group-item">
								Payment Status<span class="label label-success pull-right"><?php echo $paymentStatus ? 'Complete':'Incomplete'; ?></span>
							</li>
							
							<li class="list-group-item">
								Work Status<span class="label label-success pull-right"><?php echo $workStatus ? 'Submitted':'Not submitted'; ?></span>
							</li>
							
							</div>
						
						</div>
						<div class="col-md-6 pull-right">
						<div class="col-md-12">
								<ul class="blocks blocks-100 "
									data-plugin="animateList" data-child=">li">
								  <li>
									<div class="panel">
										<div class="panel-heading">
										<h3 class="panel-title">Actual Document</h3>
									
										</div>
									  <figure class="overlay overlay-hover animation-hover">
										   <object class="caption-figure" data="<?php echo $document1;?>"></object> 
				<!--
										<img class="caption-figure" src="<?php echo $document;?>">
				-->
										<figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align">
											<a href="<?php echo !empty($up1l)? $upl1:'javascript:void(0);'; ?>"  <?php echo !empty($upl1)? "target='_blank'" :""; ?> class="btn btn-outline btn-default project-button">
														Task Document
													</a> 
										 
										</figcaption>
									  </figure>
									  <div class="time pull-right"><?php echo date('d F Y',strtotime($crd)) ?></div>
									  <div class="text-truncate"><?php echo $title; ?></div>
									</div>
								  </li>
								</ul>
							</div>
							<div class="col-md-12">
							<ul class="blocks blocks-100"
								data-plugin="animateList" data-child=">li">
							
							  <li>
								<div class="panel">
									<div class="panel-heading">
									<h3 class="panel-title">Uploaded by Client</h3>
									</div>
								  <figure class="overlay overlay-hover animation-hover">
									   <object class="caption-figure" data="<?php echo $document;?>"></object> 
			<!--
									<img class="caption-figure" src="<?php echo $document;?>">
			-->
									<figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align">
										<a href="<?php echo !empty($upl)? $upl:'javascript:void(0);'; ?>"  <?php echo !empty($upl)? "target='_blank'" :""; ?> class="btn btn-outline btn-default project-button">
													View Document 
												</a> 
									 
									</figcaption>
								  </figure>
								  <div class="time pull-right"><?php echo date('d F Y',strtotime($upd)) ?></div>
								  <div class="text-truncate"><?php echo $title; ?></div>
								</div>
							  </li>
							</ul>
						</div>
						</div>
						
						
				 </div>
				
			  </div>
<!--
          endtask
-->
          	</div>
        </div>
    </div>
</div>
