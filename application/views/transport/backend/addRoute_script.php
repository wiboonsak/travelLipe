<script>
	
	function addRoute(){
		
			var route_name_en = $('#route_name_en').val();
			var begin_place_id = $('#begin_place_id').val();
			var destination_place_id = $('#destination_place_id').val();
		
			if(route_name_en ==''){
				swal({
				   title: 'Please insert route name !',
				   confirmButtonClass: 'btn btn-confirm mt-2',
				   type: 'warning'
				})
				
			}else if(begin_place_id ==''){
				swal({
				   title: 'Please insert begin place !',
				   confirmButtonClass: 'btn btn-confirm mt-2',
				   type: 'warning'
				})
			
			}else if(destination_place_id ==''){
				swal({
				   title: 'Please insert destination place !',
				   confirmButtonClass: 'btn btn-confirm mt-2',
				   type: 'warning'
				})
				
			}else{  
				
				var form_data = $('#frm1').serialize();
				var route_image = $('#route_image').val();								
				var dataID = $('#dataID').val();
				
				//if(dataID != ''){
					
				   var nameFunction = 'do_addRoute';				   	
					
				/*} else {
				   var nameFunction = 'do_editddRoute';				   	
				}*/
				
				var postData = new FormData($("#frm1")[0]);
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url('TransportCMS/')?>'+nameFunction,
					processData: false,
					contentType: false,
					data: postData,
					success: function(data, status){				
						
						//console.log(data);
						//$('#currentID').val(data);
						// console.log("File Uploaded");
						//console.log('data->' + data + '  status->' + status);
						if(data >0){
							swal({
								title: 'Saved Successfully.',
								//text: 'You clicked the button!',
								type: 'success',
								confirmButtonClass: 'btn btn-confirm mt-2'
							}).then(okey => {
								if(okey){
									window.location.href = "<?php echo base_url('TransportCMS/AddRoute/')?>"+data;
								}
							})

						} else {
							swal({
								title: "Data can't be saved. !",
								//text: "You won't be able to revert this!",
								type: 'warning',
								confirmButtonClass: 'btn btn-confirm mt-2'
							});
						}
					}
				});
			}
	}
	//----------------------
	
	$(".fileupload-exists").click(function(){ 
  		$("#upload_preview").empty();
		$("#upload_preview").addClass("fileupload-exists");
		$("#upload_new").removeClass("fileupload-exists");
		$("#route_image").val("");
		$("[data-provides=fileupload]").removeClass("fileupload-exists");									
		$("[data-provides=fileupload]").addClass("fileupload-new");									
	})
	//----------------------
	
	var myarray = [];	
	function select_transport(transport_id, transport){

			$('#divSelectTransport').css('display', 'block');
			$('#divSelectTransport').append('<button style="margin-top: 10px;" type="button" class="btn btn-sm btn-success divX" id="span_'+transport_id+'">&nbsp;&nbsp;'+transport+'&nbsp;&nbsp;<i class="fa fa-times" onclick="remove_transport('+transport_id+')" title="Click to delete" ></i></button> &nbsp; ');
			
			myarray.push(transport_id);
			//arr_transport = $('#arr_transport').val(myarray);
			$('#arr_transport').val(myarray);

	}
        /////////////////////////////////////////////////
        	var myarray = [];
                
	function remove_transport(transport_id){

			$('#span_'+transport_id).remove();
			myarray.splice($.inArray(transport_id, myarray), 1);
			$('#arr_transport').val(myarray); 

	}
	//----------------------
	
	function add_routeType(){ //alert('1');
		
		var arr_transport = $('#arr_transport').val();
		var route_id = $('#dataID').val();
		var transfer_h_time = $('#transfer_h_time').val();
		var transfer_m_time = $('#transfer_m_time').val();
		
		if(transfer_h_time ==''){
			swal({
				title: 'Please insert travel time (Hour) !',
				confirmButtonClass: 'btn btn-confirm mt-2',
				type: 'warning'
			})
			
		}else if(transfer_m_time ==''){
			swal({
				title: 'Please insert travel time (Minute) !',
				confirmButtonClass: 'btn btn-confirm mt-2',
				type: 'warning'
			})
		
		}else if(arr_transport ==''){  
			swal({
				title: 'Please select transport for route !',
				confirmButtonClass: 'btn btn-confirm mt-2',
				type: 'warning'
			})
				
		}else{ 
		
			$.post('<?php echo base_url('TransportCMS/add_transport')?>' , { arr_transport : arr_transport , route_id : route_id , transfer_h_time : transfer_h_time , transfer_m_time : transfer_m_time }, function(data){   //alert('...'+data);

				if(data !=''){   				
					
					/*$('.spanX').remove();
					$('#divSelectTransport').css('display', 'none');
					$('#transfer_h_time').val('');
					$('#transfer_m_time').val('');
					$('.checkboxName').prop('checked',false); 
					$('#arr_transport').val('');
					myarray.length = 0;*/
					reset_element();
					var arr2 = [];
					arr2 = data.split("/");	

					$.post('<?php echo base_url('TransportCMS/modal_setTime')?>' , { key : arr2[1] , route_id : arr2[0] }, function(data2){   
						//console.log(data2);
						var myObj = JSON.parse(data2);
						//alert('ok');
						$('#myModalLabel').text(myObj.txt_routeType);
						$('.modal-body').empty();
						$('.modal-body').html(myObj.htmlFom);
						$('#modal_Large').modal('show'); 
					})		
				}					
			})		
		} 
	}
	//----------------------
	
	function appendTime(){
		
		$('#divTime').append('<br><input type="time" name="arrive_time[]" class="form-control" >');
		
	} 
	//----------------------
	
	function insertTimes(route_type_id,route_id){
		
		if($("input[type=time]").filter(function(){ return $(this).val(); }).length > 0){
			
			var form_data = $('#frmTime').serialize();
			//alert('มีเวลาอยู่');
			$.post('<?php echo base_url('TransportCMS/insert_times')?>' , { form_data : form_data , route_type_id : route_type_id , route_id : route_id }, function(data){
				
					if(data == 1){
					   //alert('ok');
					   showRouteType_Times(route_type_id);	
					   $('#modal_Large').modal('hide'); 
					   swal({
							title: 'Saved Successfully.',
							//text: 'You clicked the button!',
							type: 'success',
							confirmButtonClass: 'btn btn-confirm mt-2'
					   })	
					}				
			})			
		}	
	}
	//----------------------
	
	function showRouteType_Times(route_type_id){
		
		var route_id = $('#dataID').val();
			
		$.post('<?php echo base_url('TransportCMS/RouteType_Times')?>' , { route_id : route_id , route_type_id : route_type_id }, function(data){				
			
			$('#accordionExample').empty();
			$('#accordionExample').html(data);
			$('#accordionExample').show();			
				
		})			
	}
	//----------------------
	
	function reset_element(){
		
		$('.divX').remove();
		$('#divSelectTransport').css('display', 'none');
		$('#transfer_h_time').val('');
		$('#transfer_m_time').val('');
		$('.checkboxName').prop('checked',false); 
		$('#arr_transport').val('');
		myarray.length = 0;				
	}
	//----------------------
	
	function addRoute_detail(dataID,route_id,key2,arrive_time){  
		
		$.post('<?php echo base_url('TransportCMS/form_routeDetail')?>' , { dataID : dataID , route_id : route_id , key2 : key2 ,arrive_time:arrive_time }, function(data2){   
			//console.log(data2);
			//var myObj = JSON.parse(data2);
			//alert('ok');
			$('#myModalLabel').text('Add / Edit Detail');
			$('.modal-body').empty();
			$('.modal-body').html(data2);
			//$('#modal_Large33').modal('show'); 
			$('#modal_Large').modal('show'); 
		})			
	}
	//----------------------
	
	function edit_routeType(key,route_id,h,m){
		
		//$('#route').css('display', 'none');
		//$('#route2').css('display', 'block');
		
		//$('.nav-tabs a[href="#route2"]').tab('show');
		
		
		$.post('<?php echo base_url('TransportCMS/editRouteType')?>' , { key : key , route_id : route_id , h : h , m : m }, function(data2){   
			//console.log(data2);
			//var myObj = JSON.parse(data2);
			//alert('ok');
		/*	$('#myModalLabel').text(myObj.txt_routeType);
			$('.modal-body').empty();
			$('.modal-body').html(myObj.htmlFom);
			$('#modal_Large33').modal('show'); */
			
			//$('#route').hide();
			//$('#route2').show();
			
			//$('#route2').empty();
			$('#route').empty();
			$('#route').html(data2);
			//$('#route2').html(data2);
		
			var xxx = "'"+key+"'";
		
			
			$('#divSelectTransport').append('&nbsp;&nbsp;&nbsp;<button style="float: right;" type="button" class="btn btn-primary" id="btnS" onClick="update_routeType('+xxx+')">Save</button>'); 
			$('#btnS').addClass('xx2');
			var transport_id = $('#arr2').val();
			
			/*for(var i = 0; i < transport_id.length; i++) {
			  console.log("loop", transport_id[i])
			}*/
			
			var arr2 = [];
			arr2 = transport_id.split(",");
			
			//console.log('LArr2 ....'+arr2.length);
			
			for(var i=0; i<arr2.length; i++){
				myarray.push(arr2[i]);
			}
			
			
			//myarray.push(arr2);
			$('#arr_transport').val(myarray);  //console.log('my a ....'+myarray);  console.log('in....'+$('#arr_transport').val());    console.log('L ....'+myarray.length); 
			
		})			
	}
	//----------------------
	 
    function setShow_onWeb(dataID, val2, table){
        var changeCheckbox = document.querySelector('.js-check-change');
        var x = changeCheckbox.checked;
        if (val2 == '0') {
            var check = '1';
        }
        if (val2 == '1') {
            var check = '0';
        }
        $.post('<?php echo base_url('PackageCMS/set_ShowOnWeb') ?>', {dataID: dataID, check: check, table: table}, function (data) {
            if (data == 1) {
                $('#ch' + dataID).val(check);
                swal({
                    title: 'Edit data successfully.',
                    //text: 'You clicked the button!',
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
            } else {
                swal({
                    title: 'Can not be edited.!',
                    //text: "You won't be able to revert this!",
                    type: 'warning',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
            }
        });
    }
	//------------------------------
	
	function delete_data(dataID,table){  
	
		swal({
           title: 'Want to delete this data ?',
           //text: "You won't be able to revert this!",
           type: 'warning',
           showCancelButton: true,
           confirmButtonClass: 'btn btn-confirm mt-2',
           cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
           confirmButtonText: 'Delete'
        }).then(function () {
			
		   $.post('<?php echo base_url('TransportCMS/deleteData')?>' , { dataID : dataID , table : table }, 
                 
			function(data){
				if(data==1){ 
                	swal({
                        title: 'Deleted Successfully',
                        //text: "Your file has been deleted",
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    }).then(okay => {
					   if (okay) {
						   location.reload();
					   }
					})
                                        }else if(data==2){
                    swal({
						title: 'Cannot delete item because the data is used. Must delete the booking first',
						//text: "You won't be able to revert this!",
						type: 'warning',
						confirmButtonClass: 'btn btn-confirm mt-2'
					});
				}else{
					swal({
						title: "Data can't be deleted. !",
						//text: "You won't be able to revert this!",
						type: 'warning',								
						confirmButtonClass: 'btn btn-confirm mt-2'
					}) 							
				}
			})	
		})
	}	
    //------------------------------------------
	
	function modal_addTimes(key,route_id){
		
			$.post('<?php echo base_url('TransportCMS/modal_setTime')?>' , { key : key , route_id : route_id }, function(data2){   
				//console.log(data2);
				var myObj = JSON.parse(data2);
				//alert('ok');
				$('#myModalLabel').text(myObj.txt_routeType);
				$('.modal-body').empty();
				$('.modal-body').html(myObj.htmlFom);
				$('#modal_Large').modal('show'); 
			})
	
	}
	//----------------------
	
	function insertDetailTime(timeTable_id,data_order,route_id,key_group){
		
		if($('#Mdestination_place_id').val() == ''){
		   swal({
				title: 'Please select Destination Place.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#Mdestination_place_id').focus();
			return false;		   
		   
		} else if($('#transport_id').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please select Transport.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#transport_id').focus();
			return false;
		
		} else if($('#arrive_time').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please insert Arrive Time.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#Hour').focus();
			return false;
			
		} else if($('#depart_time').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please insert Depart Time.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#Hour2').focus();
			return false;
		
		} else if($('#price').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please insert Adult Price.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#price').focus();
			return false;
		
		} else {		
			
			var form_data = $('#frmDetail').serialize();
			$.post('<?php echo base_url('TransportCMS/insert_detailTime')?>' , { form_data : form_data , timeTable_id : timeTable_id , data_order : data_order }, function(data){
				
				  if(data != 'x'){
					   
					   showRouteType_Times(key_group);
					   swal({
							title: 'Saved Successfully.',
							//text: 'You clicked the button!',
							type: 'success',
							confirmButtonClass: 'btn btn-confirm mt-2'
					   }).then(function (){						   
						   addRoute_detail(timeTable_id,route_id,key_group);
					   })					  
				 }				
			})	}	
	}
	//----------------------
	
	function placedataupdate(changeValue) {  // console.log('c..'+changeValue);
        $.post('<?php echo base_url('Welcome/placedataupdate') ?>', {changeValue: changeValue}, function (data) {
         	
			//console.log('..'+data);
			$('#destination_place_id').empty();
         	$('#destination_place_id').html(data);
		});
	}	
	//----------------------
	
	function cancelEdit(){
		
		/*$('#transfer_h_time').val('');
		$('#transfer_m_time').val('');
		$('#arr_transport').val('');
		$('#divSelectTransport').empty();
		$('#divSelectTransport').hide();
		//$('.js-check-change').removeAttr('checked');
		 $('input:checkbox').attr('checked',false);*/
		reset_element();
		showRouteType_Times('x');
		$('#btn_cancel').remove();
	}
	//----------------------
	
	function editDetail(dataID){  
		
		$.post('<?php echo base_url('TransportCMS/edit_routeDetail')?>' , { dataID : dataID }, function(data2){   
			//console.log(data2);
			//var myObj = JSON.parse(data2);
			//alert('ok');
			$('#myModalLabel').text('Add / Edit Detail');
			$('.modal-body').empty();
			$('.modal-body').html(data2);
			//$('#modal_Large33').modal('show'); 
			$('#modal_Large').modal('show'); 
		})			
	}
	//----------------------
	
	function updateDetailTime(dataID){  
		
		if($('#Mdestination_place_id').val() == ''){
		   swal({
				title: 'Please select Destination Place.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#Mdestination_place_id').focus();
			return false;		   
		   
		} else if($('#transport_id').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please select Transport.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#transport_id').focus();
			return false;
		
		} else if($('#arrive_time').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please insert Arrive Time.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#Hour').focus();
			return false;
			
		} else if($('#depart_time').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please insert Depart Time.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#Hour2').focus();
			return false;
		
		} else if($('#price').val() == ''){
				//alert('Please select Editor in Chief.');	
			swal({
				title: 'Please insert Adult Price.',
				//text: "You won't be able to revert this!",
				type: 'warning',								
				confirmButtonClass: 'btn btn-confirm mt-2'
			}) 
			$('#price').focus();
			return false;
		
		} else {	
			
			var form_data = $('#frmEdit').serialize();
			$.post('<?php echo base_url('TransportCMS/update_routeDetail')?>' , { dataID : dataID , form_data : form_data }, function(data2){ 
				
				if(data2 == 1){
					
				   swal({
						title: 'Saved Successfully.',
						//text: 'You clicked the button!',
						type: 'success',
						confirmButtonClass: 'btn btn-confirm mt-2'
				   }) 	
					
				   showRouteType_Times('x');
				   $('#modal_Large').modal('hide'); 
					
				}
				
				
				//console.log(data2);
				//var myObj = JSON.parse(data2);
				//alert('ok');
				/*$('#myModalLabel').text('Add / Edit Detail');
				$('.modal-body').empty();
				$('.modal-body').html(data2);*/
				//$('#modal_Large33').modal('show'); 
				
				//$('#modal_Large').modal('hide'); 
			})			
	   }
	}
	//---------------------- 
	
	function setTimetoInput(Hour,Minute,element){  
		
		var Hour2 = $('#'+Hour).val();
		var Minute2 = $('#'+Minute).val();	
		var time = Hour2+':'+Minute2;
		$('#'+element).val(time);		
	}
	//----------------------
	
	function update_routeType(key_group){		
		
		var arr_transport = $('#arr_transport').val();
		var route_id = $('#dataID').val();
		var transfer_h_time = $('#transfer_h_time').val();
		var transfer_m_time = $('#transfer_m_time').val();
		var old_arr = $('#arr2').val();
		
		if(transfer_h_time ==''){
			swal({
				title: 'Please insert travel time (Hour) !',
				confirmButtonClass: 'btn btn-confirm mt-2',
				type: 'warning'
			})
			
		}else if(transfer_m_time ==''){
			swal({
				title: 'Please insert travel time (Minute) !',
				confirmButtonClass: 'btn btn-confirm mt-2',
				type: 'warning'
			})
		
		}else if(arr_transport ==''){  
			swal({
				title: 'Please select transport for route !',
				confirmButtonClass: 'btn btn-confirm mt-2',
				type: 'warning'
			})
				
		}else{ 
		
			$.post('<?php echo base_url('TransportCMS/updateRouteType')?>' , { arr_transport : arr_transport , route_id : route_id , transfer_h_time : transfer_h_time , transfer_m_time : transfer_m_time , key_group : key_group , old_arr : old_arr }, function(data){   
console.log('...'+data);
				if(data == '1'){   	
					
					reset_element();
					showRouteType_Times('x');
					$('#btn_cancel').remove();					
						
				}					
			})		
		} 		
	}
	//----------------------   
	
	function delete_routeType(key_group,route_id){  
		
		swal({
           title: 'Want to delete this data ?',
           //text: "You won't be able to revert this!",
           type: 'warning',
           showCancelButton: true,
           confirmButtonClass: 'btn btn-confirm mt-2',
           cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
           confirmButtonText: 'Delete'
        }).then(function () {
			
		   $.post('<?php echo base_url('TransportCMS/deleteRouteType')?>' , { key_group : key_group , route_id : route_id }, function(data2){
			   
				if(data2 == '1'){ 
                	swal({
                        title: 'Deleted Successfully',
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    })
					reset_element();
					showRouteType_Times('x');
					
		   		}else{
					
					swal({
						title: "Data can't be deleted. !",
						type: 'warning',								
						confirmButtonClass: 'btn btn-confirm mt-2'
					}) 							
				}
			})	
		})				
	}
	//----------------------  
	
	function removeDetail(dataID,timeTable_id){
	
		 swal({
			   title: 'Want to delete this data ?',
			   //text: "You won't be able to revert this!",
			   type: 'warning',
			   showCancelButton: true,
			   confirmButtonClass: 'btn btn-confirm mt-2',
			   cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
			   confirmButtonText: 'Delete'
		}).then(function () {

			   $.post('<?php echo base_url('TransportCMS/remove_detail')?>' , { dataID : dataID , timeTable_id : timeTable_id }, function(data2){

					if(data2 == 1){ 
						swal({
							title: 'Deleted Successfully',
							type: 'success',
							confirmButtonClass: 'btn btn-confirm mt-2'
						})
						//reset_element();
						showRouteType_Times('x');

					}else{

						swal({
							title: "Data can't be deleted. !",
							type: 'warning',								
							confirmButtonClass: 'btn btn-confirm mt-2'
						}) 							
					}
			  })	
		})
	}
	//----------------------
	
    function removeFile(dataID, file_name){
        var txt2 = 'Want to delete this data ?';
        swal({
            title: txt2,
            //text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'Delete'
        }).then(function (){
            $.post('<?php echo base_url('TransportCMS/remove_file')?>', { dataID : dataID, file_name : file_name },
                    function (data){
                        if(data == '1'){
                            swal({
                                title: 'Deleted Successfully',
                                //text: "Your file has been deleted",
                                type: 'success',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            }).then(okay => {
                                if(okay){
                                   /* if(txt1 == 'ไฟล์'){
                                        $('#' + field + dataID).val('');
                                        $('#up_file' + ch).show();
                                        $('#aFile0' + ch).hide();
                                        $('#aFile' + ch).hide();
                                    }
                                    if (txt1 == 'รูปภาพ') {*/
                                        $("#upload_preview").empty();
                                        $("#upload_preview").addClass("fileupload-exists");
                                        $("#upload_new").removeClass("fileupload-exists");
                                        $("#"+field).val("");
                                        $("#"+field+dataID).val("");
                                        $("[data-provides=fileupload]").removeClass("fileupload-exists");
                                        $("[data-provides=fileupload]").addClass("fileupload-new");
                                    //}
                                }
                            })
                        } else {
                            swal({
                                title: "Data can't be deleted. !",
                                //text: "You won't be able to revert this!",
                                type: 'warning',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            })
                        }
                    })
        })
    }
     function deleteTime(TimeID , TimeName, route_type_id){
		 		swal({
			   title: 'Want to delete '+TimeName+' ?',
			   //text: "You won't be able to revert this!",
			   type: 'warning',
			   showCancelButton: true,
			   confirmButtonClass: 'btn btn-confirm mt-2',
			   cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
			   confirmButtonText: 'Delete'
			}).then(function () {

			   $.post('<?php echo base_url('TransportCMS/deleteTime')?>' , { TimeID : TimeID }, 
				function(data){  
					if(data==1){ 
						swal({
							title: 'Deleted Successfully',
							//text: "Your file has been deleted", 
							type: 'success',
							confirmButtonClass: 'btn btn-confirm mt-2'
						}).then(okay => {
						   if (okay) {
							   //location.reload();
							   showRouteType_Times(route_type_id)
						   }
						})				
					}else{
						swal({
							title: "Data can't be deleted. !",
							//text: "You won't be able to revert this!",
							type: 'warning',								
							confirmButtonClass: 'btn btn-confirm mt-2'
						}) 							
					}
				})	
			})
	 }

</script>

<script type="text/javascript">
   $(document).ready(function(){
		$('#table2').DataTable();
	   
	    showRouteType_Times('x');
	   
	 /*   $('[data-plugin="switchery"]').each(function (idx, obj){
       		new Switchery($(this)[0], $(this).data());
		});*/
				
   })
</script>

</body>
</html> 