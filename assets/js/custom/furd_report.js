$(document).ready(function(){
	var base_url  = $('#base_url').val();
	$('#marks_entry_check').validate({
		rules:{
			exam_type:{required:true},
			medium:{required:true},
			class:{required:true},
			section:{required:true},
			},
		messages:{
			},
	});
	$(document).on('click','#generate_report',function(){
		var form_valdate = $('#marks_entry_check').valid();
		if($('#class').val() >= 14){
			if($('#sub_group').val() == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false;
				}else{
					$('#sub_group_err').css('display','block');
					}
		}
		var formdata = new FormData();
		formdata.append('exam_type',$('#exam_type').val());
		formdata.append('medium',$('#medium').val());
		formdata.append('class',$('#class').val());
		formdata.append('sub_group',$('#sub_group').val());
		formdata.append('section',$('#section').val());
		if(form_valdate == true){
			$.ajax({
					type:'POST',
					url:base_url+'Production_ctrl/furd_report',
					data:formdata,
					dataType:'json',
					anync : false,
					beforeSend:function(){ $('#loader').modal('show'); },
					success:function(response){
						$('#loader').modal('hide');
						console.log(response);
						i=1;
						if(response.status == 200){
							var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
							var i = 1;
							var x ='<link rel="stylesheet" type="text/css" href="'+base_url+'assets/css/bootstrap.min.css">';
							   x=x+'<link rel="stylesheet" type="text/css" href="'+base_url+'assets/css/marksheet-result.css">';
							   x=x+'<link rel="stylesheet" type="text/css" media="print" href="'+base_url+'assets/css/marksheet-result-print.css">';
							   x=x+'<div class="class-wise-report-section-main"><div class="classwise-reportbox">'+
							   		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:25px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
							   		'<div class="header-sec-f"><b class="sv">'+response.result.org_details.school[0].school_name+', '+response.result.org_details.school[0].address+' </b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of '+response.result.org_details.exam_type[0].et_name+', '+response.result.org_details.session[0].session_name+'</b></td><td><b>Class: '+response.result.org_details.class[0].class_name+'/'+response.result.org_details.section[0].section_name+'</b></td></tr></tbody></table></div>'+
							   	   '<table class="table class-wise-report-r">'+
							   		'<thead>'+
	    								'<tr>'+
	    									'<th>Sr. No.</th>'+
	    									'<th>Student Name</th>'+
	    									'<th>Admission No.</th>'+
	    									'<th>Roll No.</th>'+
	    									'<th>Class/Section</th>';

	    									$.each(response.result.subjects,function(k,v){
	        									x=x+'<th>'+v.sub_name+'</th>';
	        								});
	    									
	    									x=x+'<th>Total</th>'+
	    									'<th>Result</th>'+
	    									'<th>Per(%)</th>'+
	    									'<th>Div</th>'+
	    									'<th>Rank</th>'+
	    								'</tr>'+
									'</thead>'+
									'<tbody>';
											$.each(response.result.furd,function(key,value){
												x=x+'<tr>'+
													'<td>'+i+'</td>'+
													'<td>'+value.name+'</td>'+
													'<td>'+value.adm_no+'</td>'+
													'<td>'+value.roll_no+'</td>'+
													'<td>'+value.class_name+'/'+value.section_name+'</td>';
													$.each(response.result.subjects,function(kk,vv){
														x=x+'<td>'+value[vv.sub_name] +'</td>';
			        								});
													x=x+'<td>'+value.total+'</td>'+
													'<td>'+value.result+'</td>'+
													'<td>'+value.percentage+'</td>'+
													'<td>'+value.division+'</td>'+
													'<td>'+value.rank+'</td>'+
													'</tr>';
												i++;
											});
										
									x=x+'</tbody>'+
								'</table>';	
								x=x+'<h5 class="section-header-title">Toppers at a Glance</h5>';
								x=x+'<table class="table topper-sec-box class-wise-report-r text-center">'+
										'<thead>'+
											'<tr>'+
												'<th>S. No.</th>'+
												'<th>Roll No.</th>'+
												'<th>Name of Student</th>'+
												'<th>Total</th>'+
												'<th>Per(%)</th>'+
												'<th>Rank</th>'+
											'</tr>'+
										'</thead>'+
										'<tbody>';
										for(var i=1; i<= 3 ;i++){
	    									$.each(response.result.furd,function(key,value){
	    										if(value.rank == i){
	    											x=x+'<tr>'+
	    											'<td>'+parseInt(key+1)+'</td>'+
	    											'<td>'+value.roll_no+'</td>'+
	    											'<td>'+value.name+'</td>'+
	    											'<td>'+value.total+'</td>'+
	    											'<td>'+value.percentage+'</td>'+
	    											'<td>'+value.rank+'</td>'+
	    											'<tr>';
	    										}
	    									});
										}
										x=x+'</tbody>'+
									'</table>';	
									x=x+'<h5 class="section-header-title">Class Abstract</h5>'+
									'<table class="table class-wise-report-r">'+
										'<thead>'+
											'<tr>'+
											'<th>S. No.</th>'+
											'<th>Teacher Name</th>'+
											'<th>Subjects</th>'+
											'<th>Total Students</th>'+
											'<th>Total App.</th>'+
											'<th>Pass</th>'+
											'<th>Pass%</th>'+
											'<th>Ist Div.</th>'+
											'<th>Per(%)</th>'+
											'<th>IInd Div.</th>'+
											'<th>III rd Div.</th>'+
											'<th>Fail</th>'+
											'<th>Highest Marks/No. of Student</th>'+
											'<th>P.I.</th>'+
											'<th>Sign</th>'+
											'</tr>'+
										'</thead>'+
										'<tbody>';									
										$.each(response.result.class_abstract,function(key,value){
											x=x+'<tr>'+
	    										'<td>'+parseInt(key+1)+'</td>'+
	    										'<td>'+value.teacher_name+'</td>'+
	    										'<td>'+value.sub_name+'</td>'+
	    										'<td>'+value.total_student+'</td>'+
	    										'<td>'+value.total_appear+'</td>'+
	    										'<td>'+value.total_pass+'</td>'+
	    										'<td>'+value.pass_percent+'</td>'+
	    										'<td>'+value.first_div+'</td>'+
	    										'<td>'+value.first_percent+'</td>'+
	    										'<td>'+value.second_div+'</td>'+
	    										'<td>'+value.third_div+'</td>'+
	    										'<td>'+value.fail+'</td>'+
	    										'<td>'+value.max_marks+'/'+value.max_marks_std+'</td>'+
	    										'<td>'+value.pi+'</td>'+
	    										'<td></td>'+
												'<tr>';
										});
										x=x+'<tbody><table></div></div>';		
								with(win.document){open(); write(x);close();}
						}else{
								alert(response.feedback); 
							}
					},
					cache:false,
					contentType:false,
					processData:false
				});
			}
	});
	$(document).on('change','#class',function(){
		var class_id = $(this).val();
		if(class_id >= 14){
			$('#sub_group_form').css('display','block');
		}else{
			$('#sub_group_form').css('display','none');
			$('#sub_group').prop('selectedIndex','');
			}
	});	
});