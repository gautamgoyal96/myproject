<style type="text/css">
  .cs-no-mr li {
  margin: 0 !important;
}
</style>
<?php //echo'<pre>'; print_r($users);echo'</pre>';?>
<table id="exampleFooAddRemove" class="table table-bordered table-hover toggle-circle"
    data-page-size="7">
    <thead>
        <tr>
            <th data-sort-initial="true" data-toggle="true">S.No</th>
            <th data-hide="phone, tablet">Transaction Id</th>
            <th data-hide="phone, tablet">User Name</th>
            <th data-hide="phone, tablet">Owner Name </th>
            <th data-hide="phone, tablet">Rented Date</th>
            <th data-hide="phone, tablet">Product Name</th>
            <th data-hide="phone, tablet">Service for</th>
            <th data-hide="phone, tablet">Price</th>
            <th data-hide="phone, tablet">Extra payment</th>
            <th data-hide="phone, tablet">Admin Fess</th>
        </tr>
    </thead>
    <tbody>
        <?php $pag=$sn-1; $sn = $sn;
        if(!empty($customer)){
            foreach($customer as $get){?>
        <tr>
            <td>
                <?php echo $sn;  ?>
            </td>
			
    
            <td><b>#<?php echo $get->transactionId;?></b></td>
            <td><?php echo $get->userName;?></td>
            <td><?php echo $get->ownerName;?></td>
            <td><?php echo $get->bookStartDate." to ".$get->bookEndDate;?></td>
            <td><a href="<?php echo base_url('user/productDetail/')."/".$get->productId;?>"><img src="<?php echo $get->productImage;?>" class="img-thumbnail" alt="" height="100" width="100"><br><?php echo $get->title;?></a></td>
            <td><?php echo $get->myProductForRental;?></td>
            <td>$ <?php echo $get->price;?></td>
            <td><?php echo $get->extraPay ? "$ ".$get->extraPay : "";?></td>
            <td>$<?php echo $get->adminFess;?> (<?php echo $get->adminPercentage;?>%)</td>
          
        </tr>
        <?php $sn++; } } if(empty($customer)):?>
        <tr class="even pointer">
            <td class=" " colspan="9">No Record Found</td>
        </tr>
        <?php endif; ?>   
    </tbody>    
</table>
<div class="">
    <?php echo $links; ?> 
</div>
<script>
    $(".delete" ).click(function() {
        $('#deleteConfirm').modal('show');
        $("#deleteUrl").attr('href',$(this).data('href'));
    });
</script>
