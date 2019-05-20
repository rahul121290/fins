$(document).ready(function(){
	var base_url = $('#base_url').val();
	$('#marksheet_form').validate({
		rules:{
			session:{required:true},
			medium:{required:true},
			section:{required:true},
			class_name:{required:true}
		},
	});
	$(document).on('click','#search',function(){
		var formvalidate = $('#marksheet_form').valid();

		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		
		if(class_name >= 14){
			if(sub_group == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		if(formvalidate){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			$.ajax({
					type:'POST',
					url:base_url+'Production_ctrl/midMarksheetGenerate',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},	
					success:function(response){
						console.log(response);
						if(response.status == 200){
							$('#loader').modal('hide');
							var x='';
							$.each(response.result.final,function(key,value){
								x=x+'<tr>'+
									'<td>'+parseInt(key+1)+'</td>'+
									'<td>'+value.name+'</td>'+
									'<td>'+value.roll_no+'</td>'+
									'<td>'+value.adm_no+'</td>'+
									'<td><button type="button" data-std_id="'+value.std_id+'" class="btn btn-primary mid_marksheet">Mid Marksheet</button></td>'+
									'<td><button type="button" data-std_id="'+value.std_id+'" class="btn btn-primary final_marksheet">Final Marksheet</button></td>'+
									'</tr>';
							});
							$('#list_of_marksheet').html(x);
						}else{
							}
					},
					cache:false,
					contentType:false,
					processData: false
				});
			}
	});
	
	//---------------------------*************--------------------------------------------
	$(document).on('click','#mid_marksheet,.mid_marksheet',function(){
		var formvalidate = $('#marksheet_form').valid();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		if(class_name >= 14){
			if(sub_group == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		if(formvalidate){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			formdata.append('std_id',$(this).data('std_id'));
			
			$.ajax({
					type:'POST',
					url:base_url+'Production_ctrl/midMarksheetGenerate',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},	
					success:function(response){
						console.log(response);
						if(response.status == 200){
							$('#loader').modal('hide');
							var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
							var x = '<link rel="stylesheet" type="text/css" href="'+ base_url +'assets/css/bootstrap.min.css">'+
	        						'<link rel="stylesheet" type="text/css" href="'+ base_url +'assets/css/marksheet-result.css">'+
	        						'<link rel="stylesheet" type="text/css" media="print" href="'+ base_url +'assets/css/marksheet-result-print.css">'+
	        						'<div class="modal-content p-head-sec">';
								$.each(response.result.final,function(key,value){
							      x=x+'<div class="modal-content p-head-sec">'+
						         '<img src="'+base_url+'assets/images/'+response.result.org_details.school[0].school_image+'" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;opacity: 0.5;filter: alpha(opacity=50);">'+
						         '<div class="modal-header p-header">'+
						            '<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="'+base_url+'assets/images/cbse-logo.png"></div>'+
						            '<div class="col-md-6 p-logo-sec text-center">'+
						               '<div class="p-school-name-sec">'+
						                  '<h2>'+response.result.org_details.school[0].school_name+'</h2>'+
						                  '<p>Affiliated to CBSE, New Delhi No. '+response.result.org_details.school[0].affiliation_no+' | School No.: '+response.result.org_details.school[0].school_no+'<br>English &amp; Hindi Medium Senior Secondary School, <br>'+response.result.org_details.school[0].address+'</p>'+
						               '</div>'+
						            '</div>'+
						            '<div class="col-md-3 p-school-logo"><img class="p-logo pull-right" src="'+base_url+'assets/images/'+response.result.org_details.school[0].school_image+'"></div>'+
						         '</div>'+
						         '<div class="modal-body p-student-body">'+
						            '<div class="student-Information 123">'+
						               '<div class="col-md-10 p-student-info">'+
						                  '<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
						                  '<div class="student-per-info">'+
						                     '<div class="student-per-info1">'+
						                        '<table class="table">'+
						                           '<tbody>'+
						                              '<tr>'+
						                                 '<td style="width:35%;">Student\'s Name</td>'+
						                                 '<td>: <b>'+value.name+'</b></td>'+
						                              '</tr>'+
						                              '<tr></tr>'+
						                              '<tr>'+
						                                 '<td>Mother\'s Name</td>'+
						                                 '<td>:'+value.m_name+'</td>'+
						                              '</tr>'+
						                              '<tr></tr>'+
						                              '<tr>'+
						                                 '<td>Father\'s Name</td>'+
						                                 '<td>:'+value.f_name+'</td>'+
						                              '</tr>'+
						                              '<tr></tr>'+
						                              '<tr>'+
						                                 '<td>Contact No.</td>'+
						                                 '<td>:'+value.contact_no+'</td>'+
						                              '</tr>'+
						                              '<tr>'+
						                                 '<td>Aadhar No.</td>'+
						                                 '<td>:'+value.aadhar_no+'</td>'+
						                              '</tr>'+
						                              '<tr>'+
						                                 '<td>Address</td>'+
						                                 '<td class="address-sec">:'+value.address+'</td>'+
						                              '</tr>'+
						                           '</tbody>'+
						                        '</table>'+
						                     '</div>'+
						                     '<div class="student-per-info2">'+
						                        '<table class="table">'+
						                           '<tbody>'+
						                              '<tr>'+
						                                 '<td>Date of Birth</td>'+
						                                 '<td>:'+value.dob+'</td>'+
						                              '</tr>'+
						                              '<tr>'+
						                                 '<td>Adm. No.</td>'+
						                                 '<td>:'+value.adm_no+'</td>'+
						                              '</tr>'+
						                              '<tr>'+
						                                 '<td>Roll No.</td>'+
						                                 '<td>:'+value.roll_no+'</td>'+
						                              '</tr>'+
						                              '<tr>'+
						                                 '<td>Class</td>'+
						                                 '<td>:'+value.class_name+'/'+value.section_name+'</td>'+
						                              '</tr>'+
						                              '<tr>'+
						                                 '<td>Attnd. Mid.Term</td>'+
						                                 '<td>:'+value.total_days+'/'+value.present_days+'</td>'+
						                              '</tr>'+
						                           '</tbody>'+
						                        '</table>'+
						                     '</div>'+
						                  '</div>'+
						               '</div>'+
						               '<div class="col-md-2 p-student-photo"><img class="student-photo" src="'+base_url+'assets/images/students/temp/'+value.photo+'?'+Math.random()+'"></div>'+
						            '</div>'+
						            '<div class="results-information p-results-information-a col-md-8">'+
						               '<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
						               '<table class="table">'+
						                  '<thead>'+
						                     '<tr>'+
						                        '<th style="width:18%;">Subjects</th>';
						                        if(class_name < '14'){
						                        	x=x+'<th>Pre Mid MM:10</th>'+
								      				'<th>Note Book: 05</th>'+
							                        '<th>Sub Enrichment: 05</th>'+
						                        	'<th>Half Yearly: 80</th>'+
							                        '<th>Marks Obtained: 100</th>'+
							                        '<th>Grade</th>';
							      				}
							      				if(class_name == '14' || class_name == '15'){
							      					x=x+'<th>Pre Mid</th>'+
							      						'<th>Out of 5 (Pre Mid)</th>'+
							      						'<th colspan="2">Mid</th>'+
							      						'<th>20% of Mid</th>';
							      				}
						                     x=x+'</tr>'+
						                  '</thead>'+
						                  '<tbody>';
					                        if(class_name == '14' || class_name == '15'){
					                        	x=x+'<tr>'+
					                        		'<td></td>'+
					                        		'<td>MM '+response.result.pre_sub[0].out_of+'</td>'+
					                        		'<td></td>'+
					                        		'<td>MM</td>'+
					                        		'<td>Marks Opt.</td>'+
					                        		'<td></td>'+
					                        	'</tr>';
					                        }
					                        
						                     $.each(response.result.mid_sub,function(k,mid_sub){
						                    	 if((mid_sub.st_id == 1) || (mid_sub.st_id == 3 && mid_sub.sub_id == value.elective_id)){
						                    	     if(value["pre_"+mid_sub.sub_name] == 'A'){
									                     var pre_marks = 'Abst.';
									                     var pre_marks_obt = '0';
									                     }else{
									                    	 var pre_marks = value["pre_"+mid_sub.sub_name];
									                    	 var pre_marks_obt = value["pre_"+mid_sub.sub_name];
									                     }
								                 	  if(value[mid_sub.sub_name+'_notebook'] == 'A'){
								                 		  var notebook = 'Abst.';
								                 		  var notebook_obt = '0';
									                 	  }else{
									                 		 var notebook = value[mid_sub.sub_name+'_notebook'];
									                 		 var notebook_obt = value[mid_sub.sub_name+'_notebook'];
										                 }
								                 	  if(value[mid_sub.sub_name+'_enrichment'] == 'A'){
								                 		var enrichment = 'Abst.';
								                 		var enrichment_obt = '0';
									                 	  }else{
									                 		 var enrichment = value[mid_sub.sub_name+'_enrichment'];	 
									                 		 var enrichment_obt = value[mid_sub.sub_name+'_enrichment'];
										                 }
								                 	  if(value[mid_sub.sub_name+'_practical'] == 'A'){
								                 		var practical = 'Abst.';	 
								                 		var practical_obt = '0';
								                 	  }else{
								                 		  var practical = value[mid_sub.sub_name+'_practical'];
								                 		  var practical_obt = value[mid_sub.sub_name+'_practical'];
								                 	  }
								                 	  if(value["mid_"+mid_sub.sub_name] == 'A'){
									                 	 var mid_marks = 'Abst.';	
									                 	 var mid_marks_obt = '0';
									                 	  }else{
									                 		 var mid_marks = value["mid_"+mid_sub.sub_name];
									                 		var mid_marks_obt = value["mid_"+mid_sub.sub_name];
										                 	  }
								                 	  
														var marks_obtained = (parseFloat(parseFloat(pre_marks_obt)+parseInt(notebook_obt)+parseInt(enrichment_obt) + parseFloat(mid_marks_obt) )).toFixed(2);
														if(marks_obtained > 90){
													          var grade = 'A1';
														}
														else if(marks_obtained > 80){
															var grade = 'A2';
														}
														else if(marks_obtained > 70){
															var grade = 'B1';
														}
														else if(marks_obtained > 60){
															var grade = 'B2';
														}
			                                            else if(marks_obtained > 50){
			                                            	var grade = 'C1';
														}
			                                            else if(marks_obtained > 40){
			                                            	var grade = 'C2';
														}
			                                            else if(marks_obtained > 32){
			                                            	var grade = 'D';
														}
			                                            else if(marks_obtained > 0){
			                                            	var grade = 'E';
														}
			                                            else{
			                                            	var grade = '-';
			                                            }												           	  	
							                    	x=x+'<tr>'+
							                    	 	'<td>'+mid_sub.sub_name+'</td>';
								                        
								                        if(class_name < '14'){
								                        	if(pre_marks == 'Abst.'){var pre_marks1 = pre_marks;}else{var pre_marks1 = (pre_marks/20*10).toFixed(2);}
								                        	if(notebook == 'Abst.'){var notebook1 = notebook;}else{var notebook1 = notebook;}
								                        	if(enrichment == 'Abst.'){var enrichment1 = enrichment;}else{var enrichment1 = enrichment;}
								                        	if(mid_marks == 'Abst.'){var mid_marks1 = mid_marks;}else{var mid_marks1 = mid_marks;}
								                        	if(marks_obtained == 'Abst.'){var marks_obtained1 = marks_obtained;}else{var marks_obtained1 = marks_obtained;}
								                        	
								                        	x=x+'<td align="center">'+pre_marks1+'</td>'+
								                        	'<td align="center">'+notebook1+'</td>'+
									                        '<td align="center">'+enrichment1+'</td>'+
								                        	'<td align="center">'+mid_marks1+'</td>'+
									                        '<td align"center"="">'+marks_obtained1+'</td>'+
									                        '<td align="center">'+grade+'</td>';
									                    }						                        
								                        if(class_name == '14' || class_name == '15'){
								                        	if(pre_marks == 'Abst.'){
								                        		var pre_out_of_5 = pre_marks;
								                        	}else{
								                        		var pre_out_of_5 = (pre_marks/20*5).toFixed(2);
								                        	}
								                        	if(mid_marks == 'Abst.'){
								                        		var mid_out_of_20 = mid_marks;
								                        	}else{
								                        		mid_out_of_20 = (mid_marks/(mid_sub.out_of)*20).toFixed(2);
								                        	}						                        	
								                        	x=x+'<td align="center">'+pre_marks+'</td>'+
								                        	'<td align="center">'+pre_out_of_5+'</td>'+
								                        	'<td align="center">'+mid_sub.out_of+'</td>'+
								                        	'<td align="center">'+mid_marks+'</td>'+
								                        	'<td align="center">'+mid_out_of_20+'</td>';
									                    }
								                     '</tr>'; 
						                    	 }
							                 });
						                  x=x+'</tbody>'+
						               '</table>'+
						            '</div>'+
						            '<div class="results-information p-results-information-c col-md-4">'+
						               '<div class="academic-result-t"><b>Co-Scholastic Areas</b></div>'+
						               '<table class="table">'+
						                  '<thead>'+
						                     '<tr>'+
						                        '<th>Subjects</th>'+
						                        '<th>Grade</th>'+
						                     '</tr>'+
						                  '</thead>'+
						                  '<tbody>';
						                  $.each(response.result.co_scholistic_sub,function(key,so_sch){
						                	  console.log(value[so_sch['sub_name']]);
						                	  x=x+'<tr>'+
						                        '<td>'+so_sch['sub_name']+'</td>'+
						                        '<td align="center">'+value[so_sch['sub_name']]+'</td>'+
						                     '</tr>'; 
							              });
						                  x=x+'</tbody>'+
						               '</table>'+
						            '</div>'+
						         '</div>';
								if(class_name == 12 || class_name == 13){
	    							x=x+'<div class="results-information p-results-information-a col-md-8">'+
	    					            '<div class="academic-result-t"><b>Computer Application</b></div>'+
	    					            '<table class="table">'+
	    					               '<thead>'+
	    					                  '<tr>'+
	    					                     '<th style="width:18%;">Subjects</th>'+
	    					                     '<th>Half Yearly:'+response.result.extra_sub[0].out_of+'</th>'+
	    					                     '<th>Grade</th>'+
	    					                  '</tr>'+
	    					               '</thead>'+
	    					               '<tbody>';
	    					               $.each(response.result.extra_sub,function(k,extra_sub){
	    					            	 x=x+'<tr>'+
	      					                     '<td>'+extra_sub['sub_name']+'</td>'+
	      					                     '<td align="center">'+value[extra_sub['sub_name']]+'</td>'+
	      					                     '<td>'+value["grade_"+extra_sub['sub_name']]+'</td>'+
	      					                  	 '</tr>'; 
	        					           });             
	    					               x=x+'</tbody>'+
	    					            '</table>'+
	    					         '</div>';	
								}
						         x=x+'<div class="modal-footer p-footer-sec">'+
						            '<div class="col-md-2 p-place-date"><b>Bhilai </b>'+currentDate+'</div>'+
						            '<div class="col-md-2 col-md-offset-4 p-techer-sign"><b>Class Teacher </b></div>'+
						            '<div class="col-md-2 col-md-offset-4 p-techer-sign"><b>Exam I/C </b></div>'+
						            '<div class="col-md-2 p-school-seal"><b>Seal of the School</b></div>'+
						            '<div class="col-md-2 text-center p-princi-sign"><img class="principle-sign" src="'+ base_url +'assets/images/'+response.result.org_details.school[0].principal_sign+'"><br>('+response.result.org_details.school[0].principal_name+')<br><b>Principal</b></div>'+
						         '</div>'+
						      '</div>';
							});
							with(win.document){open(); write(x);close();}
						}else{
							alert('something getting wrong!!!');
							}
					},
					cache:false,
					contentType:false,
					processData:false
				});
			}
	});
	//----------------****************----------------------
	$(document).on('change','#class_name',function(){
		var class_name = $(this).val();
		if(class_name >= 14){
			$('#sub_group_row').css('display','block');
		}else{
			$('#sub_group_row').css('display','none');
			$('#sub_group').prop('selectedIndex','');
			}	
	});
	
	//----------get current date----------------
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var currentDate = (day<10 ? '0' : '') + day + '-' + (month<10 ? '0' : '') + month + '-' + d.getFullYear();
});