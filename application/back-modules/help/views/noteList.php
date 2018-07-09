   <div class="oneAdded reorder-reward-list">
              <div class="ui-sortable-handle">
                <div class="reward_link">
<?php foreach ($note as $k => $val):
 ?>
  <div class="row">
    <div class="col-md-8 col-xs-7">
      <div class="form-group">
        <input class="form-control" name="note[]" type="text" value="<?php echo $val->note; ?>" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" >
        <input type="hidden" value="<?php echo $val->id; ?>" name="noteId[]"> 
      </div>
    </div>

    <div class="col-md-1 col-xs-2" >
  <a href="javascript:void(0);" class="btn btn-danger remove_field" id="ds" title="Remove field" onclick="removeRew('<?php echo $val->id; ?>')"><label class="label"><i class=" fa fa-minus "></i></label>
    </a>
 <!--    <div class="">
    <a title="Add field" class="add_btn btn btn-danger" href="javascript:void(0);"><label class="label  "> <i class="fa fa-plus"></i></label></a>
    </div> -->
    </div>
    <div class="col-md-3 col-xs-3">
    </div>
  </div> 
<?php endforeach;  ?>
<div class="AddNot"></div>
  <div class="row">
  <div class="col-md-8 col-xs-7">
  <div class="form-group">
  <input class="form-control" name="note[]" type="text" value="" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" >
  <input type="hidden" value="0" name="noteId[]"> 
  </div>
  </div>

  <div class="col-md-1 col-xs-2" >
  <!--   <a href="javascript:void(0);" class="btn btn-danger remove_field" id="ds" title="Remove field" onclick="removeRew(1)"><label class="label"><i class=" fa fa-minus "></i></label>
  </a> -->
  <div class="">
  <a title="Add field" class="add_btn btn btn-danger" href="javascript:void(0);"><label class="label  "> <i class="fa fa-plus"></i></label></a>
  </div>
  </div>
  <div class="col-md-3 col-xs-3">
  </div>
  </div>

 </div> 
  </div> 
  </div>
  <script type="text/javascript">
    var max_fields      = 10; //maximum input boxes allowed
var wrapper         = $(".AddNot"); //Fields wrapper
var add_button      = $(".add_btn"); //Add button ID

var x = 1; //initlal text box count
$(add_button).click(function(e){ //on add input button click
e.preventDefault();
if(x < max_fields){ //max input box allowed
x++; //text box increment
$(wrapper).append('<div class="cs12"><div class="row"><div class="col-md-8 col-xs-7"><div class="form-group"><input class="form-control" name="note[]" type="text" placeholder="" ><input type="hidden" value="0" name="noteId[]"></div></div><div class="col-md-1 col-xs-2" ><a href="javascript:void(0);" class="btn btn-danger remove_field" id="ds" title="Remove field"><label class="label"><i class=" fa fa-minus "></i></label></a></div><div class="col-md-3 col-xs-3"></div></div></div>'); //add input box
}
});

$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
e.preventDefault(); $(this).parent().parent().remove(); x--;
});
  </script>
