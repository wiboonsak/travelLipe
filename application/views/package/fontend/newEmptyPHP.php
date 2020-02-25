<div class="stateroom-cat">
          <?php $route_id = $this->transport_model->checkRoute($routedata,$placedata);
                              if($route_id!=0){
                                  $x=''; $n=1; $txt_routeType =''; $times1='';
                                  $Routetype = $this->transport_model->get_routeType($route_id,$x, '1', 'yes', 'key_group');
foreach ($Routetype->result() as $Data){ 
                        $countDetail = $this->transport_model->count_detailTimeTable($route_id,$Data->key_group);
                        $countnum = $countDetail->num_rows();
                        if($countnum >0){
                        $routeType2 = $this->transport_model->get_routeType($route_id, $Data->key_group, '1', $x, 'id');		
		foreach($routeType2->result() as $routeType3){ 
			
			if($n == 1){ $txt = ''; } else { $txt = ' + '; }
			
			$listTransport = $this->transport_model->listTransport($x,$routeType3->transport_id);
			foreach($listTransport->result() as $listTransport2){}			
			$txt_routeType = $txt_routeType.$txt.$listTransport2->transport_name_en;
		
		$n++; }
                
                              ?>
                                                <h2 class="title-detail" style="color: #2f79b1;"><?php echo $txt_routeType?></h2>

                                                <!-- Accordion -->
                                                <div class="panel-group" id="accordion">
  <?php  $times = $this->transport_model->get_timeDetail($route_id,$Data->key_group,'1');	
						   $numTime = $times->num_rows();
                                                   $p =1;
						   if($numTime >0){						   	
						   		foreach($times->result() as $times2){  
						   		$times1 = date('H:i', strtotime($times2->arrive_time.'+'.$Data->transfer_h_time.' hours'));	
						   		$times1 = date('H:i', strtotime($times1.'+'.$Data->transfer_m_time.' minutes'));
                                                                $price1 = $this->transport_model->getPrice($times2->id,'price','1');
                                                                $price2 = $this->transport_model->getPrice($times2->id,'price_children','1');
                                                                $price3 = ($price1*$Adults)+($price2*$Children);
                                                                ?>
                                                    <!-- Accordion 1 -->
                                                    <div class="panel">
                                          
                                            <div class="panel-heading" id="heading<?php echo $times2->id?>">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $times2->id?>">
                                                                                                                <i class="fa fa-circle" aria-hidden="<?php //if($p ==1){ echo 'true'; }?>" style="color:#A4A4A4"></i> <?php echo $times2->arrive_time?> > <?php echo $times1?>
                                                        <span style="padding-left: 30px;"><i class="fa fa-clock-o" style="color:#A4A4A4"></i> <?php if($Data->transfer_h_time!=''){echo $Data->transfer_h_time = str_replace("0", "", $Data->transfer_h_time); } ?> h <?php echo $Data->transfer_m_time?> m</span>
                                                        <span style="padding-left: 30px;"><i class="fa fa-money" style="color:#A4A4A4"></i> <?php echo number_format($price3)?> THB</span>
                                                        <span class="icon fa fa-angle-down"></span>
                                                    </a>
                                                </h4>                                              
                                            </div>
                                            
                                            <div id="collapse<?php echo $times2->id?>" class="panel-collapse collapse <?php //if($p ==1){ echo 'in'; }?>" aria-labelledby="heading<?php echo $times2->id?>">
                                                <?php $checkDetail = $this->transport_model->checkDetail($times2->id, '1');
                                                $numchDetail = $checkDetail->num_rows();
                                                if($numchDetail>0){
                                                    $a =1; $arr =''; $arr2 ='';
 foreach ($checkDetail->result() as $checkDetail2){	
                                $pricedetail1 = $this->transport_model->getPrice($times2->id,'price','1',$checkDetail2->data_order);
                                $pricedetail2 = $this->transport_model->getPrice($times2->id,'price_children','1',$checkDetail2->data_order);
                                $pricedetail3 = ($pricedetail1*$Adults)+($pricedetail2*$Children);
                                $arr = $arr.'/'.$pricedetail1;
                                $arr2 = $arr2.'/'.$pricedetail2;
                                                ?>
                                                
                                                <div class="panel-body">                                                   
                                                    <div class="container" style="background-color: #f1f1f1; border: 1px solid #E5E5E5">
														<div class="row" style="padding-top: 20px">
															<div class="col-sm-5">
																<div class="item">
																	<span><i class="fa fa-map-marker"></i></span>
                                                                                                                                        <div><strong><?php echo $checkDetail2->arrive_time?> <?php $checkroute = $this->Package_model->list_placeData($checkDetail2->begin_place_id);  foreach ($checkroute->result() as $checkroute2){} echo $checkroute2->place_name_en?></strong> </div>
																</div>
	<?php $checktransport = $this->Package_model->list_transportData($checkDetail2->transport_id);foreach ($checktransport->result() as $checktransport2){} ?>															<div class="item">
																	<span><i class="<?php echo $checktransport2->icon_class?>" aria-hidden="true"  style="color:#2f79b1;"></i></span>
                                                                                                                                        <div style="color:#2f79b1;"><strong><?php  echo $checktransport2->transport_name_en?></strong> &nbsp;&nbsp;<i class="fa fa-info-circle" style="font-size:20px"onclick="transportData('<?php echo $checkDetail2->transport_id?>')"></i></div>
																	<p>
																	   <small><strong>Note : </strong><?php echo $checkDetail2->note_checkin_en?><br>
</small>
																	</p>
<p><button type="button" class="" data-toggle="collapse" data-target="#price1<?php echo $checkDetail2->id?>" style="font-size: 10pt !important"> <?php echo $Total?> Travellers = <?php echo number_format($pricedetail3)?> THB <span style="float: right; padding-left: 15px;"> <i class="fa fa-chevron-down" aria-hidden="true"></i> </span></button>
																		<div id="price1<?php echo $checkDetail2->id?>" class="collapse">
																			<ul>
																				<li style="font-size: 10pt; font-weight: 100;"><?php echo $Adults?> Adults x <?php echo number_format($pricedetail1)?> = <?php echo number_format($Adults*$pricedetail1)?> THB </li>
																				<li style="font-size: 10pt; font-weight: 100;"><?php echo $Children?> Children x <?php echo number_format($pricedetail2)?> = <?php echo number_format($Children*$pricedetail2)?> THB</li>
																			</ul>
																		</div>
																	</p>																	</div>
																
																<div class="item-end">
																	<span><i class="fa fa-map-marker"></i></span>
																	<div><strong><?php echo $checkDetail2->depart_time?> <?php $checkroute3 = $this->Package_model->list_placeData($checkDetail2->destination_place_id); foreach ($checkroute3->result() as $checkroute4){}echo $checkroute4->place_name_en?></strong></div>																	
																</div>
															</div>
<?php $r = '1';
if($a == 1){ 
    $listroute = $this->transport_model->listRoute($r,$routedata);
     foreach($listroute->result() as $listroute2){}       
            ?> 															<div class="col-sm-3">
																<img src="<?php echo base_url('uploadfile/').$listroute2->route_image?>" class="img-responsive" style="padding: 20px 0px;" onclick="mapData('<?php echo $routedata?>')">
															</div>
 <?php } ?>														</div>
 <?php if($numchDetail == $a){  ?>                                                     
 <div>
     <button type="submit" class="awe-btn awe-btn-medium awe-book" onclick="selecttrip('<?php echo $times2->id?>','<?php echo $Data->key_group?>','<?php echo $arr?>','<?php echo $arr2?>','<?php echo $price3?>')">
																Select this trip</button>
														</div>                                                       
 <?php } ?>													</div>                                                    
                                                </div>
 <?php $a++; }}?>                                       
                                            </div>
                                        </div>
                                                         <?php $p++; }}?>
                                                    <!-- End Accordion 1 -->

                                                </div>
                                                <!-- Accordion -->
                                                 <?php $txt_routeType='';$n=1;}}}?>
                                            </div>


