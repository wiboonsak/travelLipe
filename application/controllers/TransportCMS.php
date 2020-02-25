<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransportCMS extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
       parent::__construct();
          $this->load->model('transport_model');
          $this->load->model('package_model');
          
		 
		  /*if($this->session->userdata('user_id')){     
		 	}else{
    		 	redirect(base_url().'login', 'refresh');
		 	}*/		
		 
    }
	//--------------------
	public function index()
	{
		//$this->load->view('fontend/curriculum');		
	}
	//-------------------
	public function AddRoute($dataID=NULL){
		
		if($dataID !=''){
			$data['dataID'] = $dataID;
			$data['listRoute'] = $this->transport_model->listRoute('1',$dataID);
			$data['listTransport'] = $this->transport_model->listTransport('Y');
		
		} else {
			$data['dataID'] = '';
		}		
		$data['listPlace'] = $this->transport_model->get_placeDataselect();
		//$this->load->view('transport/backend/header');
		$this->load->view('package/backend/header');
		$this->load->view('transport/backend/addRoute_view' , $data);		
		$this->load->view('transport/backend/footer');		
		$this->load->view('transport/backend/addRoute_script');		
				
	}
	//-------------------
	public function editRoute($dataID=NULL){
		
		$data['dataID'] = $dataID;
		$data['listRoute'] = $this->transport_model->listRoute('1',$dataID);
		$data['listTransport'] = $this->transport_model->listTransport('Y');
		$data['listPlace'] = $this->transport_model->get_placeDataselect();
		
		//$this->load->view('transport/backend/header');
		$this->load->view('package/backend/header');
		$this->load->view('transport/backend/addRoute_view' , $data);		
		$this->load->view('transport/backend/footer');		
		$this->load->view('transport/backend/addRoute_script');		
				
	}
	//-------------------
	public function RouteManage(){
		
		$data['listRoute'] = $this->transport_model->listRoute('1');
		
//		$this->load->view('transport/backend/header');
                $this->load->view('package/backend/header');
		$this->load->view('transport/backend/routeList_view' , $data);		
		$this->load->view('transport/backend/footer');		
		$this->load->view('transport/backend/addRoute_script');		
				
	}
	//-------------------
	public function do_addRoute(){
		
		$route_name_en = $this->input->post('route_name_en'); 
        $begin_place_id = $this->input->post('begin_place_id'); 
        $destination_place_id = $this->input->post('destination_place_id');
        $old_pic = $this->input->post('old_pic');
        $dataID = $this->input->post('dataID');
		
		$upload_path = './uploadfile/';
		$upload_pathName = 'uploadfile/';
		$config['upload_path'] = $upload_path;
		//allowed file types. * means all types
		$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
		//allowed max file size. 0 means unlimited file size
		$config['max_size'] = '0';
		//max file name size
		$config['max_filename'] = '50';
		//whether file name should be encrypted or not
		$config['encrypt_name'] = TRUE;
		//store image info once uploaded
		$image_data = array();
		//check for errors
		$is_file_error = FALSE;
		$result = 0;
		
		//if (isset($_FILES['file_name2']['name'])) {
	/*	if ($_FILES['file_name2']['name'] !='') {
           
				 $this->load->library('upload', $config);
				  if (!$this->upload->do_upload('file_name2')) {
                    //if file upload failed then catch the errors
                   // $this->handle_error($this->upload->display_errors());
                    //$is_file_error = TRUE;
					  echo "ErrorUpload";
                } else { 
				  	$image_data = $this->upload->data();
                    //$config['image_library'] = 'gd2';
                    $config['source_image'] = $image_data['full_path']; //get original image
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 1024;
                    $config['height'] = 1024;
                    $this->load->library('image_lib', $config);
					//if (!$this->image_lib->resize()) {
                    //   echo "ErrorResize";
                   // }else{ 
				  					  
					  
						$this->load->helper("file");
						
					    @unlink($old_file);				
						$filed='file_name';
						
						$imgNameUpdate2 = $upload_pathName.$this->upload->data('file_name');
						$resultUpdateBooking = $this->news_model->updateFile($newsID , $imgNameUpdate2 ,$filed );
						if($resultUpdateBooking==1){ 
							$Result = 2;
						}else{ 
							$Result = 0;
						 }
					//}
				}
				//----------------
		}*/
		$this->load->library('upload', $config);
		//$countFilesTH = count($_FILES['file_th']['name']);
		//$countFilesEN = count($_FILES['file_en']['name']);		
		
		if($_FILES['route_image']['name'] !=''){
           
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('route_image')){
                //if file upload failed then catch the errors
                // $this->handle_error($this->upload->display_errors());
                //$is_file_error = TRUE;
				echo "ErrorUpload";
            } else { 
				$image_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_data['full_path']; //get original image
                //$config['maintain_ratio'] = TRUE;
                //$config['width'] = 1024;
                //$config['height'] = 1024;
                $this->load->library('image_lib', $config);
				//if (!$this->image_lib->resize()) {
                //   echo "ErrorResize1:";
                // }else{ 
				$this->load->helper("file");					   
				@unlink($old_pic);
				
				$filed='first_pic';
				$imgNameUpdate = $upload_pathName.$this->upload->data('file_name');
				/*$resultUpdateBooking = $this->news_model->updateFile($newsID , $imgNameUpdate , $filed);
				if($resultUpdateBooking==1){ 	
					$Result = 1;
					/*echo $imgNameUpdate;
					$this->load->helper("file");
					$path = base_url('./');
					@unlink('./'.$oldImg);*/
/*				}else{ 
					$Result = 0;
					//echo 'ไม่สามารถเพิ่มรูปได้';
				}*/
					//}
			}
				//----------------
		} else {
			
			$imgNameUpdate = $old_pic;
		}		
		
        if($dataID == ''){
            $result = $this->transport_model->insertRoute($route_name_en, $begin_place_id, $destination_place_id, $imgNameUpdate);
			
        } else {
			
            $result = $this->transport_model->editRoute($route_name_en, $begin_place_id, $destination_place_id, $imgNameUpdate, $dataID);
        }
        echo $result;		
				
	}
	//-------------------	
	public function add_transport(){
		$transport_id = $this->input->post('arr_transport');
		$route_id = $this->input->post('route_id');		
		$transfer_h_time = $this->input->post('transfer_h_time');		
		$transfer_m_time = $this->input->post('transfer_m_time');		
		$result = $this->transport_model->selectTransport($transport_id, $route_id, $transfer_h_time, $transfer_m_time);
		echo $result;
	}                                         
    //------------------------
	public function modal_setTime(){   
		
		$txt_routeType =''; $x =''; $n =1;
		$key = $this->input->post('key');
		$route_id = $this->input->post('route_id');	
		$data = $this->transport_model->get_routeType($route_id, $key, '1', $x, 'id');
		
		foreach($data->result() as $routeType){ 
			
			if($n == 1){ $txt = '';  } else { $txt = ' + '; }
			
			$listTransport = $this->transport_model->listTransport($x,$routeType->transport_id);
			foreach($listTransport->result() as $listTransport2){}
			
			$txt_routeType = $txt_routeType.$txt.$listTransport2->transport_name_en;
		
		$n++; }
		
		$txt_script = "'".$key."' , '".$route_id."'";
		
		$aa['htmlFom'] = '<form id="frmTime" role="form" method="post" action="" enctype="multipart/form-data">
				<div class="form-group row">
                    <label class="col-md-3 col-sm-12 col-form-label">Add Time</label>
                    <div class="col-md-7" id="divTime">
                        <input type="time" name="arrive_time[]" class="form-control" >
                    </div>
					<div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="appendTime()">Add Time</button>
                    </div>
                 </div>
			 
				 <br><div class="col-12" style="text-align: center;">
				 	 <button type="button" class="btn btn-success btn-sm" onclick="insertTimes('.$txt_script.')" >Submit</button> 	
				 </div></form>';
		$aa['txt_routeType']=$txt_routeType;
		echo json_encode($aa);
 	} 
	//------------------------
	public function insert_times(){  
	
		$form_data = $this->input->post('form_data');
		$route_type_id = $this->input->post('route_type_id');
		$route_id = $this->input->post('route_id');		
		$params = array();
		parse_str($form_data, $params);
		  //print_r($params);
		$Result = $this->transport_model->do_insertTimes($params,$route_type_id,$route_id);
		echo $Result;	
	}
	//------------------------
	public function RouteType_Times(){ 	
		
		$route_id = $this->input->post('route_id');	  
		$key_group = $this->input->post('route_type_id');	  
		$x =''; $txt_routeType =''; $n =1; $times1 =''; 		
		$data = $this->transport_model->get_routeType($route_id, $x, '1', 'yes', 'key_group');
		foreach($data->result() as $routeType){  

		$routeType2 = $this->transport_model->get_routeType($route_id, $routeType->key_group, '1', $x, 'id');		
		foreach($routeType2->result() as $routeType3){ 
			
			if($n == 1){ $txt = ''; } else { $txt = ' + '; }
			
			$listTransport = $this->transport_model->listTransport($x,$routeType3->transport_id);
			foreach($listTransport->result() as $listTransport2){}			
			$txt_routeType = $txt_routeType.$txt.$listTransport2->transport_name_en;
		
		$n++; }

		if(($routeType->key_group == $key_group) && ($key_group != 'x')){ $p = 1; } else { $p = 0; }			
			
		$count_routeType = $this->transport_model->count_routeType($routeType->key_group,$route_id);
		if($count_routeType >0){ $dis = 'disabled'; $style2 = 'cursor: not-allowed'; } else { $dis = ''; $style2 =''; }	
			
			
?>		
		
		 <div class="card">
             <div class="card-header" id="heading<?php echo $routeType->key_group?>"  data-toggle="collapse" data-target="#collapse<?php echo $routeType->key_group?>" aria-expanded="<?php if($p == 1){ echo 'true'; } else { echo 'false'; }?>" aria-controls="collapse<?php echo $routeType->key_group?>" style="cursor: pointer" >
             <h5 class="m-0">
                 <a href="#" class="text-dark" ><?php echo $txt_routeType?></a>
				 <button type="button" style="float: right" class="btn btn-danger waves-effect waves-light btn-sm" onClick="delete_routeType('<?php echo $routeType->key_group?>' , '<?php echo $route_id?>')">Delete</button>
				 <button type="button" style="float: right; margin-left: 10px; margin-right: 10px; <?php echo $style2?>" class="btn btn-primary waves-effect waves-light btn-sm" onClick="edit_routeType('<?php echo $routeType->key_group?>' , '<?php echo $route_id?>' , '<?php echo $routeType->transfer_h_time?>' , '<?php echo $routeType->transfer_m_time?>')" <?php echo $dis;?> >Edit</button>
				 <button type="button" style="float: right" class="btn btn-success waves-effect waves-light btn-sm" onClick="modal_addTimes('<?php echo $routeType->key_group?>' , '<?php echo $route_id?>')">Add Time</button>
             </h5>
             </div>
                                    
             <div id="collapse<?php echo $routeType->key_group?>" class="collapse <?php if($p == 1){ echo 'show'; }?>" aria-labelledby="heading<?php echo $routeType->key_group?>" data-parent="#accordionExample">
                <div class="card-body">
                   <?php   $times = $this->transport_model->get_timeDetail($route_id,$routeType->key_group,'1');	
						   $numTime = $times->num_rows();	
						   if($numTime >0){						   	
						   		foreach($times->result() as $times2){  
						   		$times1 = date('H:i', strtotime($times2->arrive_time.'+'.$routeType->transfer_h_time.' hours'));	
						   		$times1 = date('H:i', strtotime($times1.'+'.$routeType->transfer_m_time.' minutes'));				
				   ?>
              
					<div>
					
					
              			   <div class="form-group row" style="margin-bottom: 0">
                              <label class="col-8 col-form-label"><?php echo $times2->arrive_time?> <i class="fa fa-play"></i> <?php echo $times1?></label>
							  <div class="col-4" style="float: right">
							   	<button type="button" style="margin-left:142px" id="btn_addRoute" class="btn btn-success waves-effect waves-light btn-sm" onClick="addRoute_detail('<?php echo $times2->id?>','<?php echo $route_id?>','<?php echo $times2->route_type_id?>','<?php echo $times2->arrive_time?>')">Add Detail</button>
                                                                 <button type="button" class="btn btn-warning waves-effect waves-light btn-sm" style="" onClick="deleteTime('<?php echo $times2->id?>' , '<?php echo $times2->arrive_time?> - <?php echo $times1?>','<?php echo $times2->route_type_id?>')"> Delete Detail</button> 
							  </div> 
							                          
                           </div>
					
						  <!-- <div class="form-group row" style="background-color: #f5f5f5;">-->
					<?php 	$checkData = $this->transport_model->get_detailTimeTable($times2->id);	
							$num = $checkData->num_rows();	   
							if($num >0){
								
								foreach($checkData->result() as $checkData2){								
									
								$placeData = $this->package_model->list_placeData($checkData2->begin_place_id);
								foreach($placeData->result() as $placeData2){}
									
								$placeData3 = $this->package_model->list_placeData($checkData2->destination_place_id);
								foreach($placeData3->result() as $placeData4){}		

								$transportData = $this->transport_model->listTransport($x,$checkData2->transport_id);
								foreach($transportData->result() as $transportData2){}			

								//$begin_place_id = $checkData2->begin_place_id;							
								$begin_place = $placeData2->place_name_en;
								//$destination_place_id = $checkData2->destination_place_id;	
								$destination_place = $placeData4->place_name_en;
								$transport = $transportData2->transport_name_en;
					?>						
						   <div class="form-group row" style="background-color: #f0f7ff;">
							<p style="margin: 10px 15px 10px 20px;">
								<label class="col-9 col-form-label" style="height: 35px"><?php echo $checkData2->arrive_time?> From <?php echo $begin_place?></label><button type="button" style="float: right; margin-left: 10px;" class="btn btn-danger waves-effect waves-light btn-sm" onclick="removeDetail('<?php echo $checkData2->id?>' , '<?php echo $checkData2->timeTable_id?>')">Delete</button><button type="button" style="float: right;" class="btn btn-primary waves-effect waves-light btn-sm" onclick="editDetail('<?php echo $checkData2->id?>') ">Edit</button>
								<label class="col-12 col-form-label"><?php echo $checkData2->depart_time?> To <?php echo $destination_place?></label>
								<label class="col-12 col-form-label"><strong>Transport :</strong> <?php echo $transport?></label>
								<label class="col-12 col-form-label"><strong>Check-in :</strong> <?php echo $checkData2->note_checkin_en?></label>
								<label class="col-12 col-form-label"><strong>Adult Price :</strong> <?php echo number_format($checkData2->price)?> THB</label>   
								<label class="col-12 col-form-label"><strong>Child Price :</strong> <?php echo number_format($checkData2->price_children)?> THB</label>   
							</p>						
						   </div>
					<?php } ?>	
						
						
						
						
						
						
						<!--<div class="form-group row" style="background-color: #dee2e6;">
							   <p style="margin: 10px 20px;">
							<label class="col-12 col-form-label">09:30 From Lipe</label>
							<label class="col-12 col-form-label">10:45 To Pak Bara Pier</label>
							<label class="col-12 col-form-label">Speed Boat</label>
							<label class="col-12 col-form-label"><strong>Check-in:</strong> 30 minutes before departure At Bundhaya Speed Boat Office in front of Bundhaya Resort on Pattaya Beach.- From May to November please check with your hotel to make sure what beach to departure from.</label>
							<label class="col-12 col-form-label"><strong>Adult Price:</strong> 1,660 THB</label>   
							<label class="col-12 col-form-label"><strong>Child Price:</strong> 1,000 THB</label>   
							  </p>
						
							</div>-->
						
						
						
						<hr style="border-top: 2px solid #0000008a;"> 
					<?php } ?>
					</div>
					
					
               			<?php } } ?>              
                </div>
             </div>
         </div>                              
		
<?php  $txt_routeType =''; $n =1;  }		
		
	} 	
	//------------------------
	public function form_routeDetail(){  // dataID , route_id

		$timeTable_id = $this->input->post('dataID');
		$route_id = $this->input->post('route_id');
		$key_group = $this->input->post('key2');
		$arrive_time = $this->input->post('arrive_time');
		
		$x =''; $arriveTime ='';		
		//$checkData = $this->transport_model->get_detailTimeTable($timeTable_id,'1','yes');		
		$checkData5 = $this->transport_model->get_detailTimeTable($timeTable_id);		
		$num = $checkData5->num_rows();	   
		if($num >0){
					
			$checkData = $this->transport_model->get_detailTimeTable($timeTable_id,$x,'yes');
			foreach($checkData->result() as $checkData2){}
			
			//$placeData = $this->package_model->list_placeData($checkData2->begin_place_id);
			$placeData = $this->package_model->list_placeData($checkData2->destination_place_id);
			foreach($placeData->result() as $placeData2){}		
			
			//$transportData = $this->transport_model->listTransport($x,$checkData2->transport_id);
			//foreach($transportData->result() as $transportData2){}			
			
			//$begin_place_id = $checkData2->begin_place_id;
			$begin_place_id = $checkData2->destination_place_id;
			$begin_place = $placeData2->place_name_en;
			$data_order = 1 + $checkData2->data_order;
			//$destination_place = $placeData4->place_name_en;
			//$transport = $transportData2->transport_name_en;
			//echo '111111.....';
			
		} else {
			
			$routeData = $this->transport_model->listRoute($x,$route_id);
			foreach($routeData->result() as $routeData2){}	
			
			$placeData = $this->package_model->list_placeData($routeData2->begin_place_id);
			foreach($placeData->result() as $placeData2){}			
			
			$transportID = $this->transport_model->get_routeType($route_id, $key_group, $x, $x, 'id', 'yes');
			foreach($transportID->result() as $transportID2){}			
			
			$transportData = $this->transport_model->listTransport($x,$transportID2->transport_id);
			foreach($transportData->result() as $transportData2){}			
			
			$arriveTime1 = $this->transport_model->get_timeDetail($route_id, $key_group, $x, 'yes');
			foreach($arriveTime1->result() as $arriveTime2){}
			
			$begin_place_id = $routeData2->begin_place_id;
			$begin_place = $placeData2->place_name_en;
			$transport = $transportData2->transport_name_en;
			$transport_id = $transportID2->transport_id;
			//$arriveTime = $arriveTime2->arrive_time;
			$data_order = '1';
			//echo '2222.....';
		}	
?>

	<form id="frmDetail" role="form" method="post" action="" enctype="multipart/form-data">			 
				 
				<div class="form-group row">					
                    <label class="col-md-3 col-sm-12 col-form-label">Begin Place</label>
                    <label class="col-md-9 col-sm-12 col-form-label" id="labelBegin"><?php echo $begin_place?></label>	
					<input type="hidden" id="Mbegin_place_id" name="begin_place_id" value="<?php echo $begin_place_id?>">
                </div>
					
				<div class="form-group row"> 
					<label class="col-md-3 col-sm-12 col-form-label">Destination Place</label>
                    <div class="col-md-9">
                        <select class="form-control" id="Mdestination_place_id" name="destination_place_id">
                            <option value="">-- Select --</option>
						<?php 	$placeData3 = $this->transport_model->get_placeData($x,$begin_place_id);
								foreach($placeData3->result() as $placeData4){ ?>	
                            <option value="<?php echo $placeData4->id?>" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '1')){ echo "selected"; }?> ><?php echo $placeData4->place_name_en?></option>
						<?php } ?>	
							
                            <!--<option value="2" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '2')){ echo "selected"; }?> >Hatyai</option>
                            <option value="3" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '3')){ echo "selected"; }?> >Surat Thani Airport</option>
                            <option value="4" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '4')){ echo "selected"; }?> >Koh Samui</option>-->
										   <!--<option value="1" <?php //if(($commentNum >0) && ($comment2->result_status == '1')){ echo "selected";  } ?>>Accepted</option>
                                           <option value="2" <?php //if(($commentNum >0) && ($comment2->result_status == '2')){ echo "selected";  } ?>>Minor Revision</option>
                                           <option value="3" <?php //if(($commentNum >0) && ($comment2->result_status == '3')){ echo "selected";  } ?>>Major Revision</option>
                                           <option value="4" <?php //if(($commentNum >0) && ($comment2->result_status == '4')){ echo "selected";  } ?>>Rejected</option>-->
                        </select>
                    </div>
                </div>
				 
				<div class="form-group row">					
				 	<label class="col-md-3 col-sm-12 col-form-label">Transport</label>	
					<?php if($num >0){ ?>
					
					<div class="col-md-9">
                        <select class="form-control" id="transport_id" name="transport_id">
                            <option value="">-- Select --</option>
						<?php 	$transportData = $this->transport_model->listTransport('Y');
								foreach($transportData->result() as $transportData2){ ?>	
                            <option value="<?php echo $transportData2->id?>" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '1')){ echo "selected"; }?> ><?php echo $transportData2->transport_name_en?></option>
						<?php } ?>	
							
                        </select>
                    </div>
					<?php } else { ?>					
				 	<label class="col-md-9 col-sm-12 col-form-label"><?php echo $transport?></label>
					<input type="hidden" id="transport_id" name="transport_id" value="<?php echo $transport_id?>">
					<?php } ?>		 
				</div> 
				 
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Arrive Time</label>
					<?php if($num >0){ ?>
					<div class="col-md-9">
                        <input type="time" name="arrive_time" id="arrive_time" class="form-control" >
                    </div>
					<?php } else { ?>					
				 	<label class="col-md-9 col-sm-12 col-form-label"><?php echo $arrive_time?></label>
					<input type="hidden" id="arrive_time" name="arrive_time" value="<?php echo $arrive_time?>">
					<?php } ?>
				</div> 
				 
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Depart Time</label>
                    <div class="col-md-9">
                        <input type="time" name="depart_time" id="depart_time" class="form-control" >
                    </div>					
				</div> 
				 
				<div class="form-group row"> 
					<label class="col-md-3 col-sm-12 col-form-label">Check-in Place</label>
                    <div class="col-md-9">
                        <textarea class="form-control" rows="5" id="note_checkin_en" name="note_checkin_en"></textarea>
                    </div>
                </div>  
					
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Adult Price</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="price" name="price" >
                    </div>&nbsp;Baht					
				</div>
				 
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Child Price</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="price_children" name="price_children" >
                    </div>&nbsp;Baht					
				</div>                
			 
				 <br><div class="col-12" style="text-align: center;">
				 	 <button type="button" class="btn btn-success btn-sm" id="btn3" onclick="insertDetailTime('<?php echo $timeTable_id?>' , '<?php echo $data_order?>' , '<?php echo $route_id?>' , '<?php echo $key_group?>')" >Submit</button> 	
				 </div>
				 
	</form>		
		
<?php 	}
	//------------------------
	public function editRouteType(){    

			$route_id = $this->input->post('route_id');	  
			$key_group = $this->input->post('key');
			$hour = $this->input->post('h');
			$minute = $this->input->post('m');
		
			$listRoute = $this->transport_model->listRoute('1',$route_id);
			$listTransport = $this->transport_model->listTransport('Y');
		
			$m =''; $n =1; $arr = array(); $txt_routeType =''; 	 	
		
			//$data = $this->transport_model->get_routeType($route_id, $key_group, '1', 'yes', 'key_group');
			$data = $this->transport_model->get_routeType($route_id, $key_group, '1', $m, 'id');	
			foreach($data->result() as $routeType){ 
				array_push($arr,$routeType->transport_id);		
			}
		
	/*	$data = $this->transport_model->get_routeType($route_id, $x, '1', 'yes', 'key_group');
		foreach($data->result() as $routeType){  

		$routeType2 = $this->transport_model->get_routeType($route_id, $routeType->key_group, '1', $x, 'id');		
		foreach($routeType2->result() as $routeType3){ 
			
			if($n == 1){ $txt = ''; } else { $txt = ' + '; }
			
			$listTransport = $this->transport_model->listTransport($x,$routeType3->transport_id);
			foreach($listTransport->result() as $listTransport2){}			
			$txt_routeType = $txt_routeType.$txt.$listTransport2->transport_name_en;
		
		$n++; }
		
		}*/
?>



	<div class="form-group row"><?php //print_r($arr)?>
                        <label class="col-md-3 col-sm-12 col-form-label">Travel Time</label>
                        <div class="col-md-4 col-sm-12">						
							
                            <select class="form-control" id="transfer_h_time" name="transfer_h_time">
                               <option value="">-- Hour --</option>
							<?php for($a=1; $a<=24; $a++){ 
								
									if($a < 10){  $txt = '0';  } else { $txt =''; }
							?>								
								<option value="<?php echo $txt.$a?>" <?php if($hour == $txt.$a){ echo "selected"; }?> ><?php echo $txt.$a?></option>	
							<?php }	?>
							</select><?php //if(($dataID !='') && ($listRoute2->begin_place_id == '1')){ echo "selected"; }?>
                       </div>
						
					   <div class="col-md-4 col-sm-12">							
							
                            <select class="form-control" id="transfer_m_time" name="transfer_m_time">
                               <option value="">-- Minute --</option>
							<?php for($x=0; $x<=59; $x++){ 
								
									if($x < 10){  $txt = '0';  } else { $txt =''; }
							?>								
								<option value="<?php echo $txt.$x?>" <?php if($minute == $txt.$x){ echo "selected"; }?> ><?php echo $txt.$x?></option>
	
							<?php }	?><?php //if(($dataID !='') && ($listRoute2->begin_place_id == '1')){ echo "selected"; }?>
							</select>
                       </div>						
                   </div>					
					
				   <div class="form-group row">	
				   		<label class="col-md-3 col-sm-12 col-form-label">Transport for Route</label>
                   		<div class="col-md-9 col-sm-12 row">	
						
				<?php  foreach($listTransport->result() as $listTransport2){ 
							
						if(in_array($listTransport2->id, $arr)){  $bb = 'checked';  } else { $bb = ''; }	
				?>				
                                     <div style="padding-top: 10px;">
                              
<!--                       			<input type="checkbox" id="transport<?php //echo $listTransport2->id?>" name="transport[]" class="checkboxName" value="<?php //echo $listTransport2->id?>" <?php //echo $bb?> onClick="select_transport('<?php //echo $listTransport2->id?>' , '<?php //echo $listTransport2->transport_name_en?>' , '<?php //echo $dataID?>' , this.checked , '1')">
                       			<label for="transport<?php //echo $listTransport2->id?>"><?php //echo $listTransport2->transport_name_en?></label>-->
                                        <button type="button" class="btn btn-sm btn-primary" onClick="select_transport('<?php echo $listTransport2->id?>' , '<?php echo $listTransport2->transport_name_en?>')" ><?php echo $listTransport2->transport_name_en?> &nbsp;<i class=" mdi mdi-plus"></i></button>
                    		</div>
					&nbsp;&nbsp;	
						
				<?php } ?>										
							<br>
							<br>
							<br>
							<div class="col-12 alert alert-info row" style="color:#000000; background-color: #FFFFFF;" id="divSelectTransport" >		
								
						<?php $xx3=''; 	//$routeType2 = $this->transport_model->get_routeType($route_id, $key_group, '1', $x, 'id');		
							foreach($data->result() as $routeType3){ 
		
			
								if($n == 1){ $txt = '';  $txt5 = ''; } else { $txt = '&nbsp;&nbsp;+&nbsp;&nbsp;'; $txt5 = ','; }
								
								$xx3 = $xx3.$txt5.$routeType3->transport_id;

								$listTransport = $this->transport_model->listTransport($m,$routeType3->transport_id);
								
								foreach($listTransport->result() as $listTransport20){}	
								$xx = $listTransport20->transport_name_en;
								//$txt_routeType = $txt_routeType.$txt.$listTransport2->transport_name_en;
							?>		
															<button style="margin-top: 10px;" type="button" class="btn btn-sm btn-success divX" id="span_<?php echo $routeType3->transport_id?>">&nbsp;&nbsp;<?php echo $xx?>&nbsp;&nbsp;<i class="fa fa-times" onclick="remove_transport('<?php echo $routeType3->transport_id?>')" title="Click to delete"></i></button> &nbsp;
								
								
<!--								<span id="span_<?php //echo $routeType3->transport_id?>" class="spanX"><?php //echo $txt?><?php //echo $xx?></span>-->
								
		
			<?php	$xx=''; 		$n++; } 
								
								//echo $txt_routeType;?>	   <!--test1   +   test  +   test  +-->
		
		<!--<span id="span_" class="spanX" >&nbsp;&nbsp;......&nbsp;&nbsp;</span>-->
													
								<!--<button type="button" class="btn btn-primary" style="float: right;">Save</button>-->
								
								
								
								
							</div>	
							<button type="button" class="btn btn-success" onClick="cancelEdit()" id="btn_cancel">Back</button>
							<input type="hidden" id="arr2" name="arr2" value="<?php echo $xx3?>" >	
				    	 </div>				    	
				   </div>				   
				   
				   <div class="form-group row">
						<div class="accordion m-b-30 col-12" id="accordionExample">
                        </div>
				   </div>

		
		
<?php 	}	
	//------------------------
	public function insert_detailTime(){  
	
		$form_data = $this->input->post('form_data');
		$timeTable_id = $this->input->post('timeTable_id');
		$data_order = $this->input->post('data_order');
		$params = array();
		parse_str($form_data, $params);
		  //print_r($params);
		$Result = $this->transport_model->do_insertDetailTime($params,$timeTable_id,$data_order);
		echo $Result;	
	}
	//------------------------
	public function edit_routeDetail(){  
	
		$dataID = $this->input->post('dataID');
	/*	
		
		$route_id = $this->input->post('route_id');
		$key_group = $this->input->post('key2');
		
		$x =''; $arriveTime ='';		
		//$checkData = $this->transport_model->get_detailTimeTable($timeTable_id,'1','yes');		
		$checkData5 = $this->transport_model->get_detailTimeTable($timeTable_id);		
		$num = $checkData5->num_rows();	   
		if($num >0){
					
			$checkData = $this->transport_model->get_detailTimeTable($timeTable_id,$x,'yes');
			foreach($checkData->result() as $checkData2){}
			
			//$placeData = $this->package_model->list_placeData($checkData2->begin_place_id);
			$placeData = $this->package_model->list_placeData($checkData2->destination_place_id);
			foreach($placeData->result() as $placeData2){}		
			
			//$transportData = $this->transport_model->listTransport($x,$checkData2->transport_id);
			//foreach($transportData->result() as $transportData2){}			
			
			//$begin_place_id = $checkData2->begin_place_id;
			$begin_place_id = $checkData2->destination_place_id;
			$begin_place = $placeData2->place_name_en;
			$data_order = 1 + $checkData2->data_order;
			//$destination_place = $placeData4->place_name_en;
			//$transport = $transportData2->transport_name_en;
			//echo '111111.....';
			
		} else {
			
			$routeData = $this->transport_model->listRoute($x,$route_id);
			foreach($routeData->result() as $routeData2){}	
			
			$placeData = $this->package_model->list_placeData($routeData2->begin_place_id);
			foreach($placeData->result() as $placeData2){}			
			
			$transportID = $this->transport_model->get_routeType($route_id, $key_group, $x, $x, 'id', 'yes');
			foreach($transportID->result() as $transportID2){}			
			
			$transportData = $this->transport_model->listTransport($x,$transportID2->transport_id);
			foreach($transportData->result() as $transportData2){}			
			
			$arriveTime1 = $this->transport_model->get_timeDetail($route_id, $key_group, $x, 'yes');
			foreach($arriveTime1->result() as $arriveTime2){}
			
			$begin_place_id = $routeData2->begin_place_id;
			$begin_place = $placeData2->place_name_en;
			$transport = $transportData2->transport_name_en;
			$transport_id = $transportID2->transport_id;
			$arriveTime = $arriveTime2->arrive_time;
			$data_order = '1';
			//echo '2222.....';
		}*/
		
		$x ='';
		$checkData = $this->transport_model->get_detailTimeTable('','','',$dataID);	
		//$num = $checkData->num_rows();	   
		//if($num >0){
								
			foreach($checkData->result() as $checkData2){}								
									
			$placeData = $this->package_model->list_placeData($checkData2->begin_place_id);
			foreach($placeData->result() as $placeData2){}
									
			$placeData3 = $this->package_model->list_placeData($checkData2->destination_place_id);
			foreach($placeData3->result() as $placeData4){}		

			$transportData = $this->transport_model->listTransport($x,$checkData2->transport_id);
			foreach($transportData->result() as $transportData2){}			

			$begin_place_id = $checkData2->begin_place_id;							
			$begin_place = $placeData2->place_name_en;
			//$destination_place_id = $checkData2->destination_place_id;	
			$destination_place = $placeData4->place_name_en;
			$transport = $transportData2->transport_name_en;
		
		
		
?>

	<form id="frmEdit" role="form" method="post" action="" enctype="multipart/form-data">			 
				 
				<div class="form-group row">					
                    <label class="col-md-3 col-sm-12 col-form-label">Begin Place</label>
                    <label class="col-md-9 col-sm-12 col-form-label" id="labelBegin"><?php echo $begin_place?></label>	
					<input type="hidden" id="Mbegin_place_id" name="begin_place_id" value="<?php echo $begin_place_id?>">
                </div>
					
				<div class="form-group row"> 
					<label class="col-md-3 col-sm-12 col-form-label">Destination Place</label>
                    <div class="col-md-9">
                        <select class="form-control" id="Mdestination_place_id" name="destination_place_id">
                            <option value="">-- Select --</option>
						<?php 	$placeData3 = $this->transport_model->get_placeData($x,$begin_place_id);
								foreach($placeData3->result() as $placeData4){ ?>	
                            <option value="<?php echo $placeData4->id?>" <?php if($placeData4->id == $checkData2->destination_place_id){ echo "selected"; }?> ><?php echo $placeData4->place_name_en?></option>
						<?php } ?>	
							
                            <!--<option value="2" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '2')){ echo "selected"; }?> >Hatyai</option>
                            <option value="3" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '3')){ echo "selected"; }?> >Surat Thani Airport</option>
                            <option value="4" <?php //if(($dataID !='') && ($listRoute2->begin_place_id == '4')){ echo "selected"; }?> >Koh Samui</option>-->
										   <!--<option value="1" <?php //if(($commentNum >0) && ($comment2->result_status == '1')){ echo "selected";  } ?>>Accepted</option>
                                           <option value="2" <?php //if(($commentNum >0) && ($comment2->result_status == '2')){ echo "selected";  } ?>>Minor Revision</option>
                                           <option value="3" <?php //if(($commentNum >0) && ($comment2->result_status == '3')){ echo "selected";  } ?>>Major Revision</option>
                                           <option value="4" <?php //if(($commentNum >0) && ($comment2->result_status == '4')){ echo "selected";  } ?>>Rejected</option>-->
                        </select>
                    </div>
                </div>
				 
				<div class="form-group row">					
				 	<label class="col-md-3 col-sm-12 col-form-label">Transport</label>	
					<?php //if($num >0){ ?>
					
					<div class="col-md-9">
                        <select class="form-control" id="transport_id" name="transport_id">
                            <option value="">-- Select --</option>
						<?php 	$transportData = $this->transport_model->listTransport('Y');
								foreach($transportData->result() as $transportData2){ ?>	
                            <option value="<?php echo $transportData2->id?>" <?php if($transportData2->id == $checkData2->transport_id){ echo "selected"; }?> ><?php echo $transportData2->transport_name_en?></option>
						<?php } ?>	
							
                        </select>
                    </div>
					<?php /*} else { ?>					
				 	<label class="col-md-9 col-sm-12 col-form-label"><?php echo $transport?></label>
					<input type="hidden" id="transport_id" name="transport_id" value="<?php echo $transport_id?>">
					<?php }*/ ?>		 
				</div> 
		
		
				<?php 	$timeArray = explode(":",$checkData2->arrive_time);
						$Hour = $timeArray[0];
						$Minute = $timeArray[1];
				?>
				 
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Arrive Time</label>
					<?php //if($num >0){ ?>
					<div class="col-md-9" style="display: inline-flex">
                       <input type="hidden" name="arrive_time" id="arrive_time" class="form-control" value="<?php echo $checkData2->arrive_time?>" >
						
						 <!--<div class="col-md-4 col-sm-12">	-->					
							
                            <select class="form-control col-5" id="Hour" name="Hour" onChange="setTimetoInput('Hour' , 'Minute' , 'arrive_time')">
                               <option value="">-- Hour --</option>
							<?php for($a=1; $a<=24; $a++){ 
								
									if($a < 10){  $txt = '0';  } else { $txt =''; }
							?>								
								<option value="<?php echo $txt.$a?>" <?php if($Hour == $txt.$a){ echo "selected"; }?> ><?php echo $txt.$a?></option>	
							<?php }	?>
							</select>&nbsp;&nbsp;
						
							<select class="form-control col-5" id="Minute" name="Minute" onChange="setTimetoInput('Hour' , 'Minute' , 'arrive_time')">
                               <option value="">-- Minute --</option>
							<?php for($a=0; $a<=59; $a++){ 
								
									if($a < 10){  $txt = '0';  } else { $txt =''; }
							?>								
								<option value="<?php echo $txt.$a?>" <?php if($Minute == $txt.$a){ echo "selected"; }?> ><?php echo $txt.$a?></option>	
							<?php }	?>
							</select><?php //if(($dataID !='') && ($listRoute2->begin_place_id == '1')){ echo "selected"; }?>
                      <!-- </div>-->
						
						
                    </div>
					<?php /*} else { ?>					
				 	<label class="col-md-9 col-sm-12 col-form-label"><?php echo $arriveTime?></label>
					<input type="hidden" id="arrive_time" name="arrive_time" value="<?php echo $arriveTime?>">
					<?php }*/ ?>
				</div> 
		
				<?php 	$timeArray2 = explode(":",$checkData2->depart_time);
						$Hour2 = $timeArray2[0];
						$Minute2 = $timeArray2[1];
				?>
				 
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Depart Time</label>
                    <!--<div class="col-md-9">
                        <input type="time" name="depart_time" id="depart_time" class="form-control" value="<?php //echo $checkData2->depart_time?>" >
                    </div>-->	
					
					
					<div class="col-md-9" style="display: inline-flex">
                        <input type="hidden" name="depart_time" id="depart_time" class="form-control" value="<?php echo $checkData2->depart_time?>" >
						
						<!--<div class="col-md-4 col-sm-12">	-->					
							
                            <select class="form-control col-5" id="Hour2" name="Hour2" onChange="setTimetoInput('Hour2' , 'Minute2' , 'depart_time')">
                               <option value="">-- Hour --</option>
							<?php for($a=1; $a<=24; $a++){ 
								
									if($a < 10){  $txt = '0';  } else { $txt =''; }
							?>								
								<option value="<?php echo $txt.$a?>" <?php if($Hour2 == $txt.$a){ echo "selected"; }?> ><?php echo $txt.$a?></option>	
							<?php }	?>
							</select>&nbsp;&nbsp;
						
							<select class="form-control col-5" id="Minute2" name="Minute3" onChange="setTimetoInput('Hour2' , 'Minute2' , 'depart_time')">
                               <option value="">-- Minute --</option>
							<?php for($a=0; $a<=59; $a++){ 
								
									if($a < 10){  $txt = '0';  } else { $txt =''; }
							?>								
								<option value="<?php echo $txt.$a?>" <?php if($Minute2 == $txt.$a){ echo "selected"; }?> ><?php echo $txt.$a?></option>	
							<?php }	?>
							</select><?php //if(($dataID !='') && ($listRoute2->begin_place_id == '1')){ echo "selected"; }?>
                      <!-- </div>-->
						
						
                    </div>
					
					
				</div> 
				 
				<div class="form-group row"> 
					<label class="col-md-3 col-sm-12 col-form-label">Check-in Place</label>
                    <div class="col-md-9">
                        <textarea class="form-control" rows="5" id="note_checkin_en" name="note_checkin_en"><?php echo $checkData2->note_checkin_en?></textarea>
                    </div>
                </div>  
					
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Adult Price</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo $checkData2->price?>" >
                    </div>&nbsp;Baht					
				</div>
				 
				<div class="form-group row">
				 	<label class="col-md-3 col-sm-12 col-form-label">Child Price</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="price_children" name="price_children" value="<?php echo $checkData2->price_children?>" >
                    </div>&nbsp;Baht					
				</div>                
			 
				 <br><div class="col-12" style="text-align: center;">
				 	 <button type="button" class="btn btn-success btn-sm" id="btn3" onclick="updateDetailTime('<?php echo $dataID?>')" >Submit</button> 	
				 </div>
				 
	</form>		
<?php  }
	
	//------------------------
	public function update_routeDetail(){  
	
		$form_data = $this->input->post('form_data');
		$dataID = $this->input->post('dataID');		
		$params = array();
		parse_str($form_data, $params);
		  //print_r($params);
		$Result = $this->transport_model->updateDetail($params,$dataID);
		echo $Result;	
	}
	//------------------------  
	public function updateRouteType(){  
		
	//	 arr_transport : arr_transport , route_id : route_id , transfer_h_time : transfer_h_time , transfer_m_time : transfer_m_time , key_group : key_group , old_arr
	
		$transport_id = $this->input->post('arr_transport');
		$route_id = $this->input->post('route_id');		
		$transfer_h_time = $this->input->post('transfer_h_time');		
		$transfer_m_time = $this->input->post('transfer_m_time');		
		$key_group = $this->input->post('key_group');		
		$old_arr = $this->input->post('old_arr');	
		
		$transport_arr = explode(",",$transport_id);
		$old_arr2 = explode(",",$old_arr);	
		
		//$cars = array();
		
		for($i=0; $i < count($old_arr2); $i++){
			
			//if($old_arr2[$i] != $transport_arr[$i]){
				//array_push($cars,$old_arr2[$i]);				
				$this->transport_model->delete_transport($key_group, $route_id, $old_arr2[$i]);				
			//}			
		}
		
		for($i=0; $i < count($transport_arr); $i++){
			
			//if($old_arr2[$i] != $transport_arr[$i]){
				//array_push($cars,$old_arr2[$i]);				
				$this->transport_model->update_routeType($transport_arr[$i], $route_id, $transfer_h_time, $transfer_m_time, $key_group);			
			//}			
		} 	
		$result = '1';
		//$this->transport_model->delete_transport($transport_id, $route_id, $transfer_h_time, $transfer_m_time);
		
		//$result = $this->transport_model->update_routeType($transport_id, $route_id, $transfer_h_time, $transfer_m_time, $key_group);
		echo $result;
			
	}
	//------------------------
	public function deleteRouteType(){  
	
		$key_group = $this->input->post('key_group');
		$route_id = $this->input->post('route_id');		
		$Result = $this->transport_model->do_deleteRouteType($key_group,$route_id);
		echo $Result;	
	}
	//------------------------
	public function remove_detail(){  
	
		$dataID = $this->input->post('dataID');				
		$timeTable_id = $this->input->post('timeTable_id');				
		$Result = $this->transport_model->do_deleteDetail($dataID,$timeTable_id);
		echo $Result;	
	}
	//------------------------ 	
    public function remove_file(){ 
		
        $file_name = $this->input->post('file_name');
        $dataID = $this->input->post('dataID');
        //$file_name = 'uploadfile/'.$file_name;
        //$img = '';
        $result = $this->transport_model->do_removeFile($dataID);
        if($result == '1'){
            $this->load->helper("file");					   
            @unlink($file_name); 
			echo $result;
        }        
    }
    //-------------------
	public function deleteData(){  
	
		$dataID = $this->input->post('dataID');				
		$table = $this->input->post('table');				
		$Result = $this->transport_model->do_deleteData($dataID,$table);
		echo $Result;	
	}
        	//------------------------TimeID
	public function  deleteTime(){
		$TimeID = $this->input->post('TimeID');
		$resultDelete = $this->transport_model->deleteRouteTime($TimeID);
		echo $resultDelete;
	} 

}