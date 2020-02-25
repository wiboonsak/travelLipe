<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct() {
        parent::__construct(); 
        $this->load->model('Package_model');
        $this->load->model('transport_model');
    }
        //-------------------	
    public function index() {
        $this->load->view('package/fontend/index');
    }
        //-------------------	
    public function package_list() {
        $this->load->view('package/fontend/package_list');
    }
        //-------------------	
    public function package_detail($currentid=null) {
        $data['currentID'] = $currentid;
        $this->load->view('package/fontend/package_detail',$data);
    }
             //-------------------	
    public function book_package($currentid=null) {
        $data['currentID'] = $currentid;
        $this->load->view('package/fontend/book_package',$data);
    }
             //-------------------	
    public function book_package_comfirm($currentid=null) {
        $data['currentID'] = $currentid;
        $this->load->view('package/fontend/book_package_comfirm',$data);
    }
             //-------------------	
    public function timetable() {
        $this->load->view('package/fontend/timetable');
    }
             //-------------------	
    public function payment() {
        $this->load->view('package/fontend/payment');
    }
             //-------------------	
    public function contact() {
        $this->load->view('package/fontend/contact');
    }
             //-------------------	
    public function email_book_transport() {
        $this->load->view('package/fontend/email_book_transport');
    }
            //------------------------------- 	
    public function AddBooking() {
        $Departing = $this->input->post('Departing');
        $Adults = $this->input->post('Adults');
        $Children = $this->input->post('Children');
        $Name = $this->input->post('Name');
        $Last = $this->input->post('Last');
        $Email = $this->input->post('Email');
        $Line = $this->input->post('Line');
        $Phone = $this->input->post('Phone');
        $currentID = $this->input->post('currentID');
        $price = $this->input->post('price');
        $accept = $this->input->post('accept');
          if(($Departing != '')&&($Departing!= '0000-00-00')){
			
			$dateArray = explode("/",$Departing);
			$date= $dateArray[0];
			$mon= $dateArray[1];
			$year= $dateArray[2];			
			$Departing = $year."-".$mon."-".$date;
		/*} else {
			$txtWhere2 = '';*/
         }
        $keygroup = $this->Package_model->generateRandomString();
        $ch_keygroup = $this->Package_model->check_keygroup($keygroup);
        if($ch_keygroup >0){
            $keygroup = $this->Package_model->generateRandomString();
        }        
        $result_id = $this->Package_model->AddBooking($Departing, $Adults, $Children, $Name ,$Last,$Email,$Line,$Phone,$currentID,$price,$keygroup,$accept);
        if($result_id==1){$result_id = $keygroup;}
        echo $result_id;
//         '............................',$Departing,$Adults,$Children,$Name,$Last,$Email,$Line,$Phone;
    }
               //-------------------	
    public function email_book_package($keygroup=null) {
        $data['keygroup'] = $keygroup;
        $this->load->view('package/fontend/email_book_package',$data);
    }
    //-------------------
	public function send_mail(){	 
		$txt='';
		/*$emaildata = $this->input->post('email');
		$typedata = $this->input->post('type');
		$userID = $this->input->post('userID');*/		
		$keygroup = $this->input->post('keygroup');				
             $checkinData = $this->Package_model->getbooking($keygroup);
             foreach($checkinData->result() as $Data){} 
             if ($Data->cf_status == 1){ $txt='Pending';}else if($Data->cf_status == 2){ $txt='Confrim ';}else{ $txt='Cancel';}
             
             $table = 'tbl_package_booking';
		$key_value1 = $this->Package_model->generateRandomString();	
		$key_value3 = $this->Package_model->generateRandomString();	
		$date1 = date("d");
		$key_value2 = $key_value1.$keygroup.'#'.$date1.$key_value3;		
		
		$from_email = 'wiboonsak.suw@gmail.com';
		$subject = "Booking Package ใบแจ้งการจองแพ็คเกจ";		
		//$to_email = $editor_data2->email;
		//$to_email = $emaildata;
		$to_email = $Data->customer_email;
		$email_body = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Booking Package</title>
<style>
	body{
		margin: 15px 0px 0px;
		
	}
	tr td{
		font-family: tahoma, serif;
		font-size: 10pt;
		color: #56201D; 
	}
</style>
</head>
        <link href="'.base_url().'assets/css/icons.css" rel="stylesheet" type="text/css" />
                <link href="'.base_url().'assets/css/style.css" rel="stylesheet" type="text/css" />
                 <link href="'.base_url().'assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#EFEFEF">
  <tbody>
    <tr>
      <td bgcolor="#EFEFEF">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height="120" bgcolor="#E7E7E7"><img src="'.base_url().'images/email/logo.png" align="left" width="550" height="127" style="margin-top: -55px; padding-left: 15px;"></td>
      <td align="right" bgcolor="#E7E7E7"><img src="'.base_url().'images/email/promotion.png" width="167" height="58"  style="padding-right: 50px;" /></td>
    </tr>
    <tr>
      <td height="70" colspan="2" bgcolor="#E7E7E7"><table width="90%"  border="0" cellspacing="2" align="center" cellpadding="0" bgcolor="#FFFFFF">
        <tbody>
          <tr>
            <td width="19%" height="25" align="right"><strong>CUSTOMER NAME : </strong></td>
            <td height="25" colspan="5" align="left">'.$Data->customer_name.' '.$Data->customer_Lastname.'</td>
          </tr>
          <tr>
            <td height="25" align="right"><strong>TEL : </strong></td>
            <td width="19%" height="25" align="left">'.$Data->customer_telephone.'</td>
            <td width="9%" height="25" align="left"><strong>EMAIL : </strong></td>
            <td width="28%" height="25" align="left">'.$Data->customer_email.'</td>
            <td width="10%" height="25" align="left"><strong>ID LINE : </strong></td>
            <td width="15%" height="25" align="left">'.$Data->IDLine.'</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="197" colspan="2" bgcolor="#E7E7E7"><table width="90%" align="center" border="0" cellspacing="4" cellpadding="0" bgcolor="#FFFFFF">
              
        <tbody>
          <tr>
            <td width="40%" height="25" align="right"><strong>PACKAGE BOOKING ID : </strong></td>
            <td width="62%" height="25" align="left">'.$keygroup.'</td>
          </tr>
          <tr>
            <td height="25" align="right"><strong>PACKAGE : </strong></td>
            <td height="25" align="left">'.$Data->package_name_en.'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>DEPARTING : </strong></td>
            <td height="25" align="left">'.$this->Package_model->GetEngDateTime1($Data->date_depart).'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>ADULT : </strong></td>
            <td height="25" align="left">'.$Data->customer_adult.'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>CHILDREN (3-10 YEARS) : </strong></td>
            <td height="25" align="left">'.$Data->customer_child.'</td>
          </tr>
            <tr>
            <td width="40%" height="25" align="right"><strong>PAYMENT TOTAL : </strong></td>
            <td height="25" align="left">'. number_format($Data->total_price).'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>STATUS : </strong></td>
            <td height="25" align="left">'.$txt.'</td>
          </tr>
          </tbody>
      </table></td>
    </tr>
    <tr>
      <td bgcolor="#B8B8B8"><img src="'.base_url().'images/email/address.png" align="left" width="287" height="97"/></td>
      <td align="right" bgcolor="#B8B8B8"><img src="'.base_url().'images/email/logo-header.png" style="padding-right: 50px;" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>';	 	
		
//		$this->email->from($from_email, 'Booking Package Moonlight Travel'); 
//        $this->email->to($to_email);
//        $this->email->subject($subject); 
//       	$this->email->message($email_body); 
//        //Send mail 
//		//$this->email->send();  
//		if($this->email->send()){ 
                    $subject = "[For Admin] Booking Package ใบแจ้งการจองแพ็คเกจ";		
                    $this->email->from($from_email, 'Booking Package Moonlight Travel'); 
        $this->email->to($from_email);
        $this->email->subject($subject); 
       	$this->email->message($email_body); 
        if($this->email->send()){ 
		   	$result2 = 1;			
        }	
          	$result = $result2;  
       // }			
		echo $result;		
	}		
	//-------------------
        public function totaladult() {
        $Adults = $this->input->post('Adults');
        $currentID = $this->input->post('currentID');
        $result = $this->Package_model->totaladult($Adults,$currentID);
        echo $result;	
        
}
         //-----------------------------------------
    public function trip_list() { 

        $Adults = $this->input->post('Adults');
        $Children = $this->input->post('Children');
        $Total = $Adults+$Children;
        $data['routedata'] = $this->input->post('routedata');
        $data['placedata'] = $this->input->post('placedata');
        $data['datedata'] = $this->input->post('datedata');
        $data['Adults'] = $Adults;
        $data['Children'] = $Children;
        $data['Total'] = $Total;
        $data['spanRoute'] = $this->input->post('spanRoute');
        $data['spanTo'] = $this->input->post('spanTo');
        $data['idroute'] = $this->input->post('idroute');
                  if(!isset($data['routedata'])){
    redirect(base_url(), 'refresh');
  }else{ 
         $this->load->view('package/fontend/trip_list',$data);
  }
    }
    //------------------dataID changeValue //
	public  function placedataupdate(){
		$changeValue = $this->input->post('changeValue');
		$placeData = $this->input->post('placeData');
		//$result = $this->Package_model->placedataupdate($changeValue);

		$arr_place = array();
        $result = $this->Package_model->placedataupdate($changeValue);
		foreach($result->result() as $placeData2){
			array_push($arr_place,$placeData2->place_name_en.":".$placeData2->destination_place_id);
		}
		sort($arr_place,SORT_NATURAL | SORT_FLAG_CASE);
?>
       <option value="">---Select---</option>
       <?php $select3 ='';    
            //foreach ($result->result() as $result2){
			for($i=0;$i < count($arr_place);$i++){
				$artxt = explode(":",$arr_place[$i]);
	            $id = $artxt[1];
				$name = $artxt[0];
				
			if($id  == $placeData){ $select3 = 'selected';}
	   ?>
		<option value="<?php echo $id?>"<?php echo $select3?>><?php echo $name?></option>
       <?php $select3 ='';  }
    }
    //------------------dataID changeValue //
	public  function transportDetail(){
		$transportID = $this->input->post('transportID');
		$transportData = $this->Package_model->list_transportData($transportID);
                foreach ($transportData->result() as $transportData2){}?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 18px; font-weight: bold;"><?php echo $transportData2->transport_name_en?> Information
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		</h5>
      </div>
      <div class="modal-body">
		  
		  <div class="row">
    <!--<div><h5><?php //echo $transportData2->transport_name_en?> Information</h5></div>
    <div>--><p class="col-12" style="padding-left: 15px; padding-bottom: 15px;"><?php echo $transportData2->transport_info_en?></p>
        <?php  $imglist = $this->Package_model->loadImg3($transportID);
        foreach ($imglist->result() AS $data) {?>
    <!--<div >--><div class="col-12 col-sm-6"><img class="img-fluid" src="<?php echo base_url('uploadfile/').$data->images?>"></div><!--</div>
    </div>-->
                <?php }?>
               </div>
		  
        
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>



        <?php }
     //---------------------------------
	public  function mapDetail(){
		$routeID = $this->input->post('routeID');
		//$listRoute = $this->transport_model->listRoute($routeID);
                //foreach ($listRoute->result() as $listRoute4){}?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
		  <div class="row">
    <img src="<?php echo base_url().$routeID?>" class="img-responsive">
               </div>
		  
        
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>



        <?php }
      //------------------dataID changeValue //
	public  function selecttrip(){
                $timesid = $this->input->post('timesid');
                $transportid = $this->input->post('transportid');
                $priceAdults = substr($this->input->post('priceAdults'),1);
                $priceChildren = substr($this->input->post('priceChildren'),1);
                $pricetotal = $this->input->post('pricetotal');
                $Adults = $this->input->post('Adults');
                $Children = $this->input->post('Children');
                $datedata = $this->input->post('datedata');
                $routeid = $this->input->post('routeid');
                 if(($datedata != '')&&($datedata!= '0000-00-00')){
			
			$dateArray = explode("/",$datedata);
			$date= $dateArray[0];
			$mon= $dateArray[1];
			$year= $dateArray[2];			
			$datedata = $year."-".$mon."-".$date;
		/*} else {
			$txtWhere2 = '';*/
         }
        $keygroup = $this->Package_model->generateRandomString();
        $ch_keygroup = $this->Package_model->check_keygroup($keygroup);
        if($ch_keygroup >0){
            $keygroup = $this->Package_model->generateRandomString();
        }        
                $selecttrip = $this->Package_model->selecttrip($timesid,$transportid,$priceAdults,$priceChildren,$pricetotal,$Adults,$Children,$datedata,$routeid,$keygroup);
                 if($selecttrip == 1){$selecttrip = $keygroup;}
                echo $selecttrip;
         }
    //-------------------	
    public function book_transport($keygroub=null) {
        $data['keygroub'] = $keygroub;
        $this->load->view('package/fontend/book_transport',$data);
    }
                //------------------------------- 	
    public function AddBookingTransport() {
        $Name = $this->input->post('Name');
        $Last = $this->input->post('Last');
        $Email = $this->input->post('Email');
        $Line = $this->input->post('Line');
        $Phone = $this->input->post('Phone');
        $keygroub = $this->input->post('keygroub');
        $accept = $this->input->post('accept');
       
        $result_id = $this->Package_model->AddBookingTransport($Name ,$Last,$Email,$Line,$Phone,$keygroub,$accept);
        if($result_id==1){$result_id = $keygroub;}
        echo $result_id;
//         '............................',$Departing,$Adults,$Children,$Name,$Last,$Email,$Line,$Phone;
    }
    //-------------------	
    public function book_transport_comfirm($keygroub=null) {
        $data['keygroub'] = $keygroub;
        $this->load->view('package/fontend/book_transport_comfirm',$data);
    }    
       //-------------------
	public function send_mailtransport(){	 
		$txt=''; $r='';		
		$keygroup = $this->input->post('keygroup');	
                //echo '.................................'.$keygroup;
             $getbooking_title = $this->Package_model->getbooking_title($keygroup);
                        foreach ($getbooking_title->result() AS $getbooking_title2) { }
                        $adultstravel = $getbooking_title2->adult_traveller;
                        $childtravel = $getbooking_title2->child_traveller;
                        $totalpeople = $adultstravel+$childtravel;
             if ($getbooking_title2->cf_status == 1){ $txt='Pending';}else if($getbooking_title2->cf_status == 2){ $txt='Confrimed ';}else{ $txt='Cancel';}
              $route_id = $getbooking_title2->route_id;
          $list_route = $this->transport_model->listRoute($r,$route_id);
          foreach ($list_route->result() AS $list_route2) {}
          $list_placebegin = $this->Package_model->list_placeData($list_route2->begin_place_id);
                        foreach ($list_placebegin->result() AS $list_placebegin2) {}
           $list_placedes = $this->Package_model->list_placeData($list_route2->destination_place_id);
                        foreach ($list_placedes->result() AS $list_placedes2) {}
              $Routetype = $this->transport_model->get_routeType($route_id, $getbooking_title2->route_type_id, $r, 'yes', 'id');
foreach ($Routetype->result() as $Data){}
$dayofweek = date('l', strtotime($getbooking_title2->date_depart));
$times = $this->transport_model->get_timeDetail($r,$r,$r,$r,$getbooking_title2->time_id);	
						   //$numTime = $times->num_rows();
                                                   
						   //if($numTime >0){						   	
                                                                foreach($times->result() as $times2){}  
						   		$times1 = date('H:i', strtotime($times2->arrive_time.'+'.$Data->transfer_h_time.' hours'));	
						   		$times1 = date('H:i', strtotime($times1.'+'.$Data->transfer_m_time.' minutes'));
             $table = 'tbl_package_booking';
		$key_value1 = $this->Package_model->generateRandomString();	
		$key_value3 = $this->Package_model->generateRandomString();	
		$date1 = date("d");
		$key_value2 = $key_value1.$keygroup.'#'.$date1.$key_value3;		
		
		$from_email = 'wiboonsak.suw@gmail.com';
		$subject = "Booking Transport ใบแจ้งการจองเรือ";		
		//$to_email = $editor_data2->email;
		//$to_email = $emaildata;
		$to_email = $getbooking_title2->cust_email;
		$email_body = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Booking Package</title>
<style>
	body{
		margin: 15px 0px 0px;
		
	}
	tr td{
		font-family: tahoma, serif;
		font-size: 10pt;
		color: #56201D; 
	}
</style>
</head>
<body>      
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height="120" bgcolor="#E7E7E7"><img src="'.base_url().'html/images/email/logo-trip.png" align="left" width="550" height="127" style="margin-top: -55px; padding-left: 15px;"></td>
      <td align="right" bgcolor="#E7E7E7"><img src="'.base_url().'html/images/email/promotion.png" width="167" height="58"  style="padding-right: 50px;" /></td>
    </tr>
    <tr>
      <td height="70" colspan="2" bgcolor="#E7E7E7"><table width="90%"  border="0" cellspacing="2" align="center" cellpadding="0" bgcolor="#FFFFFF">
        <tbody>
          <tr>
            <td width="19%" height="25" align="right"><strong>CUSTOMER NAME  :</strong></td>
            <td height="25" colspan="5" align="left">'.$getbooking_title2->cust_name.' '.$getbooking_title2->cust_lastname.'</td>
          </tr>
          <tr>
            <td height="25" align="right"><strong>TEL :</strong></td>
            <td width="19%" height="25" align="left">'.$getbooking_title2->cust_telephone_num.'</td>
            <td width="9%" height="25" align="left"><strong>EMAIL  :</strong></td>
            <td width="28%" height="25" align="left">'.$getbooking_title2->cust_email.'</td>
            <td width="10%" height="25" align="left"><strong>ID LINE :</strong></td>
            <td width="15%" height="25" align="left">'.$getbooking_title2->cust_line.'</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="197" colspan="2" bgcolor="#E7E7E7">
       <table width="90%" align="center" border="0" cellspacing="4" cellpadding="0" bgcolor="#FFFFFF">
        <tbody>
          <tr>
            <td width="40%" height="25" align="right"><strong>BOOKING ID :</strong></td>
            <td width="62%" height="25" align="left">'.$keygroup.'</td>
          </tr>
          <tr>
            <td height="25" align="right"><strong>ROUTING :</strong></td>
            <td height="25" align="left">'.$list_placebegin2->place_name_en.'  to  '. $list_placedes2->place_name_en.'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>DEPARTING :</strong></td>
            <td height="25" align="left">'. $dayofweek.','. $this->Package_model->GetEngDateTime2($getbooking_title2->date_depart).'</td>
          </tr>
          <tr>  
            <td width="40%" height="25" align="right"><strong>TIME :</strong></td>
            <td height="25" align="left">'.$times2->arrive_time.' > '. $times1.'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>ADULT :</strong></td>
            <td height="25" align="left"> '.$adultstravel.'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>CHILDREN (3-10 YEARS) :</strong></td>
            <td height="25" align="left"> '. $childtravel.'</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>PAYMENT TOTAL : </strong></td>
            <td height="25" align="left">'. number_format($getbooking_title2->total_price).' THB</td>
          </tr>
          <tr>
            <td width="40%" height="25" align="right"><strong>STATUS : </strong></td>
            <td height="25" align="left">'.$txt.'</td>
          </tr>
          
          <tr>
            <td colspan="2">
            	<!------ Trip Detail ------->         
       			<div style="margin:0 auto; padding: 10px; background-color: #FFFFFF; width: 84%">            
				 <h2 class="title-detail" style="color: #2f79b1;">Trip Details:</h2>
				 <!-- Accordion -->
					  <div class="panel-group no-margin" id="accordion">
								  <!-- Accordion 1 -->
								  <div class="panel">
									 <div id="collapseOne" class="panel-collapse collapse in" aria-labelledby="headingOne">';
                                                                         
                                                  $checkDetail = $this->transport_model->checkDetail($getbooking_title2->time_id);
                                                    $a =0; 
                                                 $priceArray = explode("/",$getbooking_title2->adult_price);
                                                 $priceArray2 = explode("/",$getbooking_title2->child_price);
 foreach ($checkDetail->result() as $checkDetail2){
     $checkroute = $this->Package_model->list_placeData($checkDetail2->begin_place_id);  foreach ($checkroute->result() as $checkroute2){}
     $checktransport = $this->Package_model->list_transportData($checkDetail2->transport_id);foreach ($checktransport->result() as $checktransport2){}
     $p1 = $priceArray[$a];
     $p2 = $priceArray2[$a];
     $totalprice = ($adultstravel*$p1)+($childtravel*$p2);
     $checkroute3 = $this->Package_model->list_placeData($checkDetail2->destination_place_id); foreach ($checkroute3->result() as $checkroute4){}
     $email_body = $email_body.'
										 <div class="panel-body" style="padding-top: 10px;">                                                   
											<div class="" style="background-color: #f1f1f1; border: 1px solid #E5E5E5">
												<div class="row" style="padding: 20px 0px 20px 25px;">
													<div class="col-sm-10">
														<div class="item">
															<span><i class="fa fa-map-marker"></i></span>
															<div><strong>'.$checkDetail2->arrive_time.' '.$checkroute2->place_name_en.'</strong></div>														</div>
														<div class="item">															<span><i class="fa fa-ship" aria-hidden="true"  style="color:#2f79b1;"></i></span>
															<div style="color:#2f79b1; padding-top: 20px;  font-size: 14pt"><strong>'.$checktransport2->transport_name_en.'</strong></div>
															<p>
<!--																<small><strong>Check-in: </strong>'.$checkDetail2->note_checkin_en.'<br></small>-->
															</p>
                                                                                                            <p style="font-size: 10pt !important"><strong><?php echo $totalpeople?> Travellers = '.number_format($totalprice).' THB</strong> 			
																<ul style="font-size: 10pt; padding-bottom: 15px !important">
																	<li style="font-size: 10pt; font-weight: 100;">'.$adultstravel.' Adults x '.number_format($p1).' = '. number_format($adultstravel*$p1).' THB</li>
																	<li style="font-size: 10pt; font-weight: 100;">'. $childtravel.' Children x '. number_format($p2).' = '. number_format($childtravel*$p2).' THB</li>
																</ul>
															</p>															
														</div>

														<div class="item-end">
															<span><i class="fa fa-map-marker"></i></span>
															<div><strong>'. $checkDetail2->depart_time.' '.$checkroute4->place_name_en.'</strong></div>																	
														</div>
													</div>														
												</div>                                                    
											 </div>
										 </div>';
 $a++; } 
										 
									$email_body = $email_body.' </div>
									 <!-- End Accordion 1 -->                                          
								   </div>
								   <!-- Accordion -->
								</div>
				 <!------ Trip Detail ------->
			   </div>
            </td>
          </tr>
        </tbody>
      </table>
      
       
      </td>
    </tr>
    
    <tr>
    <td bgcolor="#B8B8B8"><img src="'.base_url().'html/images/email/address.png" align="left" width="287" height="97"/></td>
      <td align="right" bgcolor="#B8B8B8"><img src="'.base_url().'html/images/email/logo-header.png" style="padding-right: 50px;" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>';		
		
//		$this->email->from($from_email, 'Booking Transport Moonlight Travel'); 
//        $this->email->to($to_email);
//        $this->email->subject($subject); 
//       	$this->email->message($email_body); 
//        //Send mail 
//		//$this->email->send();  
//		if($this->email->send()){ 
                    $subject = "[For Admin] Booking Transport ใบแจ้งการจองเรือ";		
                    $this->email->from($from_email, 'Booking Transport Moonlight Travel'); 
        $this->email->to($from_email);
        $this->email->subject($subject); 
       	$this->email->message($email_body); 
        if($this->email->send()){ 
		   	$result2 = '1';		
        }	
          	$result = $result2;  
        //}			
		echo $result;		
	}
            //------------------------------------------
	public  function checkemail(){
		$changeValue = $this->input->post('email');
		$result = $this->Package_model->count_email($changeValue);
		echo $result;
		
	}
            //-------------------------
    public function subsribe(){
        $sub = $this->input->post('sub');
         $result = $this->Package_model->addsub($sub);
        echo $result;
    }
}

