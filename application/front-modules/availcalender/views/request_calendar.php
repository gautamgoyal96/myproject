
<main class="site-content mycsCal" role="main">
<div id="showcal">
              <?php
 require APPPATH . '/libraries/calendar_en.php';
?>
<?php if($this->session->userdata('userType') == 2 || $this->session->userdata('calType')==1 && !empty($this->session->userdata('pId'))){?>
<div class="calAction">
  <a class="pull-left" href="javascript:void(0)" onclick="doneData();">Done</a>
  <a class="pull-right" href="javascript:void(0)" onclick="clearcallendarData();">Clear</a>
</div>
<?php }?>
</div>

               </main>
               <?php  $slot =  $this->session->userdata('slot');
                      $requestDate =  $this->session->userdata('requestDate');
                      $pId =  $this->session->userdata('pId');
                 ?>

               <script type="text/javascript">

                 var slot = "<?php echo $slot;?>";
                 var pId = "<?php echo $pId;?>";

              </script>

