<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends CI_Model {

	function upload_img($profileImage,$folder){ 

		$this->makedirs($folder);

		$config = array(
					'upload_path' => './uploads/'.$folder,
					'allowed_types' => "gif|jpg|png|jpeg",
					'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'encrypt_name'=>TRUE
				 );

		$this->load->library('upload',$config);

       if(!$this->upload->do_upload($profileImage)){

			$error = array('error' => $this->upload->display_errors());
			return $error;

        } else {

			$image_data = $this->upload->data($profileImage); //upload the image
			$this->load->library('image_lib');
			$folder_thumb = $folder.'/thumb/';
			$this->makedirs($folder_thumb);
            $width = 100;
			$height = 100;
            $resize['source_image'] = $image_data['full_path'];
			$resize['new_image'] = realpath(APPPATH . '../uploads/' . $folder_thumb);
			$resize['maintain_ratio'] = true;
			$resize['width'] = $width;
			$resize['height'] = $height;
            $this->image_lib->initialize($resize);
			$this->image_lib->resize();
			$folder_resize = $folder.'/resize/';
			$this->makedirs($folder_resize);
			$this->image_lib->clear();
            return $image_data['file_name'];


		}

	} //End Function 

	function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='/uploads/'){

		if(!@is_dir(FCPATH . $defaultFolder)) {
        	mkdir(FCPATH . $defaultFolder, $mode);
		}
		if(!empty($folder)) {
	        if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
			mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
		}
		} 
	} //End Function 

	function updateGallery($fileName,$folder)
	{
		  	$this->makedirs($folder);

			$storedFile 		= array();
			$allowed_types 		= "gif|jpg|png|jpeg"; 
			$files 				= $_FILES[$fileName];
			$number_of_files 	= sizeof($_FILES[$fileName]['tmp_name']);

			// we first load the upload library
			$this->load->library('upload');
			// next we pass the upload path for the images
			$configG['upload_path'] 		= 'uploads/'.$folder;
			$configG['allowed_types'] 		= $allowed_types;
			$configG['max_size']    		= '2048000';
			$configG['encrypt_name']  		= 'TRUE';
			$configG['quality'] 			= '100%';
	   
			// now, taking into account that there can be more than one file, for each file we will have to do the upload
			for ($i = 0; $i < $number_of_files; $i++)
			{
				$_FILES[$fileName]['name'] 		= $files['name'][$i];
				$_FILES[$fileName]['type'] 		= $files['type'][$i];
				$_FILES[$fileName]['tmp_name'] 	= $files['tmp_name'][$i];
				$_FILES[$fileName]['error'] 	= $files['error'][$i];
				$_FILES[$fileName]['size'] 		= $files['size'][$i];

				//now we initialize the upload library
				$this->upload->initialize($configG);
				if ($this->upload->do_upload($fileName))
				{
					$savedFile = $this->upload->data();//upload the image
				
					$folder_thumb = $folder.'/thumb/';
					$this->makedirs($folder_thumb);
					//your desired config for the resize() function
					$config1 = array(
						'image_library' 	=> 'gd2',
						'source_image' 		=> $savedFile['full_path'], //get original image
						'maintain_ratio' 	=> false,
						'create_thumb' 		=> false,
						'width' 			=> 100,
						'height' 			=> 100,
						'new_image' 		=> realpath(FCPATH .'uploads/'.$folder_thumb),
						'quality'			=> '100%'
					);	
					$this->load->library('image_lib'); //load image_library
					$this->image_lib->initialize($config1);
					$this->image_lib->resize();
									
						
						$storedFile[$i]['name'] = $savedFile['file_name'];
						$storedFile[$i]['type'] = $savedFile['file_type'];
					
					$this->image_lib->clear();


				}
				else
				{
					//$storedFile[$i]['error'] = $this->upload->display_errors();
				}
			} // END OF FOR LOOP
		 
		return $storedFile;
		  
	}//FUnction

	function qrCode($code,$name){

		$path = 'qrCode';
		$this->makedirs('qrCode');
		$this->load->helper('security');
		$filename = time().$code.'.png';
		
		$params['data'] 	= $code;
		$params['level'] 	= 'H';
		$params['size'] 	= 10;
		$params['savename'] = FCPATH.'uploads/'.$path.'/'.$filename;
		$image=$this->ciqrcode->generate($params);
		if($image):
			return $filename;
		endif;
		return FALSE;
	}
	
}//End Class
