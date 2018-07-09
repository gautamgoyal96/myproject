<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>Imarke</title>
<style type="text/css">
  h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
 text-align: center;
}
</style>
</head>
<body>
<div class="page-main">
  <div class="page-header">
    <h1 class="page-title text-center">
    
      <?php echo $userDetail['fullName']."  Elegility Questionnaire"; ?> 
    </h1>
  </div>
    <div class="page-content">
      <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title text-center"style="color: #C0262C;text-align: center;">
                      <?php echo $category; ?>
                   </h3>
            </div>
            <div class="panel-body">
                  <div class="row">
                             <div class="col-md-12">

                              <?php
                              $questionres =$question['questions'];
                              if(!empty($questionres)){
                    for ($i=0; $i < sizeof($questionres) ; $i++) { ?>
                             <div class="" id="step<?php echo 0; ?>" style="background:#C0262C ;color:white; height: 30px;padding-left: 10px;padding-bottom:15px">
          
                               <p><strong><?php echo "Step ".($i+1).": ".$questionres[$i]['title']; ?></strong></p>
                              
                            </div>
                            <br>
                                <?php 
                                  $que=$questionres[$i]['question'];
                                  //print_r($que);
                                  for ($j=0; $j <sizeof($que) ; $j++) {
                                ?>
                             <div class="quesList">
                              
                               <div class="questionGroup">
                              
                                <b><?php echo "Q. ".$que[$j]['question']; ?>. </b>
                                <p><span><b>Ans: </b></span><?php 
                                    if(!is_array($que[$j]['answer'])){


                                echo  $que[$j]['answer'];
                                }else{  
                                echo implode(",",$que[$j]['answer']) ;?>
                                    
                                <?php } ?></p>
                                
                               </div>
                              </div>
                              <?php } }// }} 

                              ?>
                              <div class="qsAction text-center">
                              
                                 <?php if($ansAprove==2): ?>
                                 <!--  <center style=color:#C0262C;font-size:20px;> Eligibility Not Approved.</center> -->
                                 <?php else: ?>
                                 <!-- <center style=color:#C0262C;font-size:20px;> Eligibility Approved.</center> -->
                                 <?php endif; ?>
                              </div>
                               <?php } // }} 
                              ?>
                              
                             </div>
                          </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
