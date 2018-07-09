<table id="exampleFooAddRemove" class="table table-bordered table-hover toggle-circle">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="">Image</th>
							<th class="text-center">Name</th>
							<th class="text-center">E-mail</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = $startFrom;if(!empty($users)){
						foreach($users as $get){ ?>
						<?php 

							$url = "";

							if(!filter_var($get->profileImage, FILTER_VALIDATE_URL) === false) { 

							 $url = $get->profileImage;

							 }else if(!empty($get->profileImage)){ 

							 $url = base_url().'../uploads/profile/'.$get->profileImage;
							} else{  

								$url = base_url().ADMIN_THEME."assets/images/images.png";
							}
         				?>
						<tr>
							<td class="text-center"><?php echo $i; ?></td>
							<td class="text-center">
								<a class="" href="<?php echo base_url()."help/helpList/".$get->id; ?>">
								<img class="img-responsive" alt="<?php echo (ucwords($get->firstName).' '.ucwords($get->lastName)); ?>" src="<?php echo $url; ?>" style="width:120px;height:100px;">
								</a>
							</td>
							<td class="text-center">
								<a class="" href="<?php echo base_url()."help/helpList/".$get->id; ?>">
								<?php echo (ucwords($get->firstName).' '.ucwords($get->lastName)); ?>
								</a>
							</td>
							<td class="text-center">
								<a class="" href="<?php echo base_url()."help/helpList/".$get->id; ?>"><?php echo $get->email; ?></a>
							</td>
						
							<td class="text-center">
								<a  href="<?php echo base_url()."help/helpList/".$get->id; ?>" class="btn btn-icon btn-info btn-outline btn-round" >
								<i class="md-eye" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
						<?php $i++;}} ?>
					</tbody>
					<fbody>
						<tr>
							<td colspan="6"><?php echo $links;?></td>
						</tr>
					</fbody>
				</table>
				<?php 
				if(empty($users)){
				echo "<center style=color:red;font-size:20px;> No record found.</center> ";
				}
				?>