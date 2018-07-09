<?php

class Image_model extends CI_Model
{
	function do_upload($type)
	{
		$uploadPath = $width = $height = $folder = '';
		$this->load->library('image_lib');
		
		if($type == 'profile'){
			$folder = 'profile';
			$this->makedirs($folder);
			$this->makedirs($folder . '/original/');
			$this->makedirs($folder . '/small');
			$uploadPath = realpath(APPPATH . '../uploads/' . $folder . '/original/');
			$width = 250;
			$height = 250;
			$overwrite = TRUE;
			$fileName = 'profile_'.$this->authData->ID;
			
			$config['max_size']	= MAX_SIZE;
			$config['overwrite'] = $overwrite;
			$config['file_name'] = $fileName;
		}
		
		
		
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = IMAGE_TYPES;
		
		//$config['encrypt_name'] = true;
		
		$this->load->library('upload', $config);

		if(!$this->upload->do_upload('upload_image')){
			$error = $this->upload->display_errors('','');
			return array('error'=>$this->upload->display_errors('',''));
			
		} else {
			$image_data = $this->upload->data(); //upload the image
			$resize['source_image'] = $image_data['full_path'];
			$resize['new_image'] = realpath(APPPATH . '../uploads/' . $folder . '/small/');
			$resize['maintain_ratio'] = true;
			$resize['width'] = $width;
			$resize['height'] = $height;

			//send resize array to image_lib's  initialize function
			$this->image_lib->initialize($resize);
			$this->image_lib->resize();
			$this->image_lib->clear();
			
			return $image_data['file_name'];
		}
		
		return FALSE;
	}
	
	/**
	* Creates directory 
	*/
	function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='uploads')
	{
		if(!@is_dir(FCPATH . $defaultFolder)){
			mkdir(FCPATH . $defaultFolder, $mode);
		}
		
		if(!empty($folder)){
			if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
				mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode);
			}
		}	
	}
	
}// End of class Image_model

?>