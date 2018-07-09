<div class="page-main">
  <div class="page-header">
    <h1 class="page-title">Prospect</h1>
  </div>
    <div class="page-content">
		  <?php if($this->session->flashdata('success') != null) : ?>
  <div class="alert dark alert-icon alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <i class="icon wb-check" aria-hidden="true"></i> <?php echo $this->session->flashdata('success'); ?> 
  </div>   
  <?php endif; ?>
      <div class="panel">
      <style type="text/css">
  .log_div img {
    border: 2px solid #c0262c;
    border-radius: 100%;
    height: 120px;
    width: 120px;
}
</style>
            <div class="panel-heading">
              <h3 class="panel-title">Add Prospect</h3>
            </div>
            <div class="panel-body">
              <form method="post" enctype="multipart/form-data">
				
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <div class="form-group text-center">
                    <div class="log_div">
                      <img src="http://www.cubaselecttravel.com/Content/images/default_user.png" id="pImg">
                      <div class="text-center upload_pic_in_album"> 
                        <input accept="image/*" class="inputfile hideDiv" id="file-1" name="profileImage" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" style="display: none;" type="file">
                        <label for="file-1" class="upload_pic">
                        <span class="fa fa-camera"></span></label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group <?php echo !empty(form_error('fullName'))?'has-error':'';?>">
                    <label>Full Name:</label>
                    <input type="text" name="fullName"  value="<?php echo set_value('fullName'); ?>" class="form-control">
                    <?php echo form_error('fullName');?>

                  </div>
                  <div class="form-group <?php echo !empty(form_error('email'))?'has-error':'';?>">
                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo set_value('email'); ?>" class="form-control">
                     <?php echo form_error('email');?>
                  </div>
                  <div class="form-group <?php echo !empty(form_error('password'))?'has-error':'';?>">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control">
                    <?php echo form_error('password');?>
                  </div>
                  <div class="form-group <?php echo !empty(form_error('categoryId'))?'has-error':'';?>">
                    <label>Category:</label>
                    <select class="form-control" name="categoryId">
                    <option value="">Select category</option>
                    <?php foreach ($category as $k=> $cat):?>
                    <option value="<?php echo $cat->categoryId; ?>"><?php echo $cat->categoryName; ?></option>
                  <?php endforeach; ?>
                  
                  </select>
                  <?php echo form_error('categoryId');?>
                  </div>
                  
                  <div class="form-group">
                  <button type="submit" class="btn btn-sm btn-primary">Add</button>
                 
                  </div>
                </div>
              </div>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="page-main"> 
<div class="page-header">
    <h1 class="page-title">Add Prospect</h1>
  </div>
    <div class="page-content">
    <div class="panel">
<section class="profileSec">
  <div class="container">
    <div class="row">
      <div class="">
        <div class="prospectPart">
          <div class="formDesign prospectForm">
            <form class="" method="" action="">
              <div class="panel-group wrap" id="bs-collapse">
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#personal">Personal Information</a>
                    </h4>
                  </div>
                  <div id="personal" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group salutation">
                            <label>Salutation:</label>
                            <select class="form-control">
                              <option value="">Mr.</option>
                              <option value="">Ms.</option>
                              <option value="">Mrs.</option>
                              <option value="">Miss.</option>
                              <option value="">Dr.</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" name="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" name="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Marital Status:</label>
                            <select class="form-control">
                              <option>Never married</option>
                              <option>Married</option>
                              <option>Widowed</option>
                              <option>Legally separated</option>
                              <option>Annulled marriage</option>
                              <option>Divorced</option>
                              <option>Common-law</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Date of Birth:</label>
                            <input type="text" name="" class="form-control datepick date">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Area of Interest:</label>
                              <ul class="checkboxes">
                                <li>
                                    <input type="checkbox" name="1" id="c1" class="checkbox" />
                                    <label for="c1">Immigrate To Canada</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="2" id="c2" class="checkbox" />
                                    <label for="c2">Work in Canada</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="3" id="c3" class="checkbox" />
                                    <label for="c3">Study in Canada</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="4" id="c4" class="checkbox" />
                                    <label for="c4">Invest in Canada</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="5" id="c5" class="checkbox" />
                                    <label for="c5">Not sure</label>
                                </li>
                              </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
   
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#children">Children</a>
                    </h4>
                  </div>
                  <div id="children" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Number of Children:</label>
                            <select class="form-control">
                              <option value="">0</option>
                              <option value="">1</option>
                              <option value="">2</option>
                              <option value="">3</option>
                              <option value="">4</option>
                              <option value="">5</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
   
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#education">Education</a>
                    </h4>
                  </div>
                  <div id="education" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Highest Level of Education:</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option>Ph. D.</option>
                              <option>Master's degree</option>
                              <option>2 or more Bachelor's degrees</option>
                              <option>Bachelor's degree (4 years)</option>
                              <option>Bachelor's degree (3 years)</option>
                              <option>Bachelor's degree (2 years)</option>
                              <option>Bachelor's degree (1 year)</option>
                              <option>Diploma, Trade certificate, or Apprenticeship (3 years)</option>
                              <option>Diploma, Trade certificate, or Apprenticeship (2 years)</option>
                              <option>Diploma, Trade certificate, or Apprenticeship (1 year)</option>
                              <option>High school diploma</option>
                              <option>Below high school diploma</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label>Name of Diploma:</label>
                          <input  type="text" name="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label>Area of Studies:</label>
                          <input  type="text" name="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label>Country of Studies:</label>
                          <input  type="text" name="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Type of Educational Institute:</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option>Public</option>
                              <option>Private</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Post-secondaries in Canada:</label>
                            <select class="form-control">
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name of bachelor's degree</label>
                            <input  type="text" name="" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
         
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#language">Language</a>
                    </h4>
                  </div>
                  <div id="language" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Have you done any English language test?</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option value="">IELTS</option>
                              <option value="">CELPIP</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Have you done TEF (Test d'évaluation de français)?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
      
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#work">Work/study In Canada (main Applicant Or Spouse)</a>
                    </h4>
                  </div>
                  <div id="work" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Have you been in Canada as a temporary foreign worker?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Number of years of full-time employment in Canada</label>
                            <select class="form-control">
                              <option value="">None</option>
                              <option value="">1 year</option>
                              <option value="">2 years or more</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group mrinput">
                            <label>Currently employed in Canada?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Left employment in Canada:</label>
                            <select class="form-control">
                              <option value="">Less than a year ago</option>
                              <option value="">More than a year ago</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Arranged employment:</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Has a certificate of qualification?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Has a provincial or territorial nomination?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
     
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#family">Family Relations/sponsorship (main Applicant Or Spouse)</a>
                    </h4>
                  </div>
                  <div id="family" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Relatives in Canada</label>
                            <select class="form-control">
                              <option>None</option>
                              <option>Mother or father</option>
                              <option>Daughter or son</option>
                              <option>Sister or brother</option>
                              <option>Niece or nephew</option>
                              <option>Grandmother or grandfather</option>
                              <option>Granddaughter or grandson</option>
                              <option>Spouse or common-law partner</option>
                              <option>Aunt or uncle</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Does this relative wish to sponsor you?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Sponsor's age:</label>
                            <select class="form-control">
                              <option value="">Younger than 18 years</option>
                              <option value="">18 years or over</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Sponsor's employment status</label>
                            <select class="form-control">
                              <option></option>
                              <option value="">Employed</option>
                              <option value="">Self-Employed</option>
                              <option value="">Unemployed</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Sponsor's family size</label>
                            <select class="form-control">
                              <option value="">0</option>
                              <option value="">1</option>
                              <option value="">2</option>
                              <option value="">3</option>
                              <option value="">4</option>
                              <option value="">5</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Sponsor's annual income</label>
                            <div class="Income">
                            <input type="text" name="" class="form-control">
                            <span>CDN$</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Currently a full-time student?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label>Have been a dependent child since before 19?</label>
                            <select class="form-control">
                              <option value="">Yes</option>
                              <option value="">No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#previousFuture">Previous And The Future Visit(s)</a>
                    </h4>
                  </div>
                  <div id="previousFuture" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Have you or your spouse previously visited Canada for work, travel, or study?</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Have you or your spouse previously applied for immigration or visa to Canada?</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group mrinput">
                            <label>Where is your preferred destination in Canada?</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option>Any</option>
                              <option>Alberta (AB)</option>
                              <option>British Columbia (BC)</option>
                              <option>Manitoba (MB)</option>
                              <option>New Brunswick (NB)</option>
                              <option>Newfoundland and Labrador (NL)</option>
                              <option>Northwest Territories (NT)</option>
                              <option>Nova Scotia (NS)</option>
                              <option>Nunavut (NU)</option>
                              <option>Ontario (ON)</option>
                              <option>Prince Edward Island (PE)</option>
                              <option>Quebec (QC)</option>
                              <option>Saskatchewan (SK)</option>
                              <option>Yukon (YT)</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Have you previously submitted an Express Entry application?</label>
                            <select class="form-control">
                              <option value="">-- Please select --</option>
                              <option value="">Yes</option>
                              <option value="">No</option>
                              <option value="">I am not sure what it is</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            
                <div class="panel">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#" href="#otherInfo">Other Info</a>
                    </h4>
                  </div>
                  <div id="otherInfo" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Country of citizenship:</label>
                            <select class="form-control">
                              <option value="" selected="selected">-- Please select --</option>
                              <option value="1">Afghanistan</option>
                              <option value="241">Aland Islands</option>
                              <option value="2">Albania</option>
                              <option value="3">Algeria</option>
                              <option value="4">American Samoa</option>
                              <option value="5">Andorra</option>
                              <option value="6">Angola</option>
                              <option value="7">Anguilla</option>
                              <option value="8">Antarctica</option>
                              <option value="9">Antigua and Barbuda</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Current country of residence:</label>
                            <select class="form-control">
                              <option value="" selected="selected">-- Please select --</option>
                              <option value="1">Afghanistan</option>
                              <option value="241">Aland Islands</option>
                              <option value="2">Albania</option>
                              <option value="3">Algeria</option>
                              <option value="4">American Samoa</option>
                              <option value="5">Andorra</option>
                              <option value="6">Angola</option>
                              <option value="7">Anguilla</option>
                              <option value="8">Antarctica</option>
                              <option value="9">Antigua and Barbuda</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Preferred Language:</label>
                            <input type="text" name="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Phone (Optional):</label>
                            <input type="text" name="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Fax (Optional):</label>
                            <input type="text" name="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Office:</label>
                            <select class="form-control" id="office" multiple>
                              <option>Afghanistan</option>
                              <option>Aland Islands</option>
                              <option>Albania</option>
                              <option>Algeria</option>
                              <option>American Samoa</option>
                              <option>Andorra</option>
                              <option>Angola</option>
                              <option>Anguilla</option>
                              <option>Antarctica</option>
                              <option>Antigua and Barbuda</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Agent:</label>
                            <select class="form-control">
                              <option value="" selected="selected">-- Please select --</option>
                              <option>Mr. Joe Biden</option>
                              <option>Mr. Kevin Smith</option>
                              <option>Mr. peter duran</option>
                              <option>Mr. Volka Kokayko</option>
                              <option>Mr. Amanpreet Guliani</option>
                              <option>Mr. xxx yyy</option>
                              <option>Mr. Crepin Bimpalou</option>
                              <option>Mr. ama bmb</option>
                              <option>Mr. Atul Nag</option>
                              <option>Ms. Nav Farmaha</option>
                              <option>Ms. Raymay Sayday</option>
                              <option>Mr. Sunil Punnathanathe</option>
                              <option>Ms. Camila Schneider</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Referred by:</label>
                            <select class="form-control">
                              <option>Friends</option>
                              <option>Friends</option>
                              <option>Google</option>
                              <option>Other</option>
                              <option>Yahoo</option>
                              <option>Your clients</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Level of Seriousness:</label>
                            <select class="form-control">
                              <option value="" selected="selected"></option>
                              <option value="A">A</option>
                              <option value="B">B</option>
                              <option value="C">C</option>
                              <option value="D">D</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group">
                            <label>Further Information:</label>
                            <textarea class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </form>
            <div class="formAction">
              <a href="#" class="btn btn-primary">Save</a>
              <a href="#" class="btn btn-primary">Access</a>
            </div>
          </div>
        </div>
      </div>
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class=" profile-tab">
          <div id="formStatus"> 
            <ul  class="nav nav-pills">
              <li class="active">
                <a  href="#pending" data-toggle="tab">Pending Form</a>
              </li>
              <li><a href="#accepted" data-toggle="tab">Accepted Form</a>
              </li>
              <li><a href="#rejected" data-toggle="tab">Rejected Form</a>
              </li>
            </ul>

              <div class="tab-content clearfix">
                <div class="tab-pane active" id="pending">
                  <div class="formList">
                    <h5>Working...</h5>
                  </div>
                </div>
                <div class="tab-pane" id="accepted">
                  <h3>Working...</h3>
                </div>
                <div class="tab-pane" id="rejected">
                  <h3>Working...</h3>
                </div>
              </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
  </div>
</section>
</div>
</div>
 -->
<script type="text/javascript">
   setTimeout(function() {
  $('.alert').fadeOut('fast');
  }, 5000);
</script>
