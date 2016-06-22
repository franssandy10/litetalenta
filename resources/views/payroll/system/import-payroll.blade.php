@extends('layouts.app')
@include('employee.reactEmployee')
@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @endsection

@section('customCss')
	{!! Html::style('assets/plugins/jquery.bxslider/jquery.bxslider.css')!!}
	{!! Html::style('assets/plugins/progress-wizzard/progress-wizard.min.css')!!}

	<style type="text/css">
		.importUpdateSlider > li > .row {
			border: 10px solid #e6e5e5;
			margin-left: 0;
   			margin-right: 0;
		}

		.importUpdateSlider > li {
			height:50vh;
		}

		.bodyWeb {
			margin-top: 20px !important;
		}

		.upload-import-update {
			width: 100%;
			height: 150px;
			border:5px dashed #CCC;
			cursor: pointer;
		}

		.upload-import-update.hovered {
			opacity: 0.5;
		}

		.progress-indicator > li.completed {
			color: #910111;
		}

		.progress-indicator > li.completed .bubble {
			background-color: #910111;
	    	color: #910111;
	    	border-color: #910111;
		}

		.progress-indicator > li.completed .bubble:before, .progress-indicator > li.completed .bubble:after {
			background-color: #910111;
	    	border-color: #910111;
		}

		.progress-indicator.stacked .stacked-text {
			top:-35px;
			text-transform: uppercase;
			font-family: 'lato-black';
			font-size: 12px;
			margin-left:65% !important;
			line-height: 3.2em;
		}

		.progress-indicator > li:last-child .bubble:after,
		.progress-indicator > li:last-child .bubble:before {
			display: none;
		}
	</style>
@endsection
@section('customjs')
    {!! Html::script('assets/plugins/jquery.bxslider/jquery.bxslider.min.js')!!}

	<script type="text/javascript">
		var importSlider = $('.importUpdateSlider').bxSlider({
		    controls: false,
		    pager: false,
		    infiniteLoop: false,
		    mode: 'vertical',
		    adaptiveHeight: true,
		    onSlideBefore: function(){
		    	var current = parseInt(importSlider.getCurrentSlide()) + 1;
		    	$('.progress-indicator li').removeClass('completed');
				for (var i = 0; i < current; i++) {
			      $('.progress-indicator li:nth-child(' + parseInt(i+1) + ')').addClass('completed');
			    }
		    },
		});



		$(document).ready(function(){

			$('.next-import').click(function(){
				importSlider.goToNextSlide();
			})

			$('.prev-import').click(function(){
				importSlider.goToPrevSlide();
			});

			$('.typeImport').click(function(){
				var id = $(this).attr('id');
				$('.templateDiv').hide();
				$('.uploader').hide();

				$('.templateDiv.' + id).show();
				$('.uploader.' + id).show();
			})

			$('.upload-import-update').click(function(){
				$(this).closest('.uploader').find('input').click();
			})

			$('.import-file').change(function(){
				importSlider.goToNextSlide();
			})

			$('.upload-import-update').on(
			    'dragover',
			    function(e) {
			        e.preventDefault();
			        e.stopPropagation();
			        $(this).addClass('hovered');
			        $(this).find('p').text('Drop to upload files');
			    }
			)
			/*$('.upload-import-update').on(
			    'dragenter',
			    function(e) {
			        e.preventDefault();
			        e.stopPropagation();
			        $(this).addClass('hovered');
			    }
			)*/
			$('.upload-import-update').on('dragleave', function(){
		        $(this).removeClass('hovered');
		        $(this).find('p').text('Click here or drag file to upload');
		    });
			$('.upload-import-update').on(
			    'drop',
			    function(e){
			        if(e.originalEvent.dataTransfer){
			            if(e.originalEvent.dataTransfer.files.length) {
			                e.preventDefault();
			                e.stopPropagation();
			                /*UPLOAD FILES HERE*/
			                upload(e.originalEvent.dataTransfer.files);
			            }
			        }
			    }
			);
		})

		function upload(files){
		    // /alert('Upload '+files.length+' File(s).');
		    importSlider.goToNextSlide();
		}
	</script>
@endsection
@section('content')
	@include('layouts.headers.general')

	<div class="container mt30">
		<div class="row">
			<div class="col l9">
				<ul class="importUpdateSlider">
					<li>
						<div class="row">
							<div class="col l12 center-align">
								<p class="titleB01 mt20">Download new template</p>
								<div class="col l12 center-align mt20 templateDiv emergencyContact">
									<!-- <img class="displayInline" src="assets/new-talenta/images/import-update-employee-5.png"> -->
									<i class="fa fa-file-excel-o fa-4x"></i>
									<p class="titleB01 black-text truncate f19 mt15">Template_Payroll_History.xlsx</p>
									<a href="#!" class="linkB01">Click here to download</a>
								</div>
								<div class="col l12 center-align mt15">
									<p class="mb20">
										<a href="#!" class="btn btnB01 mr5 next-import">Skip</a>
									</p>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="row">
							<div class="col l12 center-align h300">
								<p class="titleB01 mt20">Upload the file</p>
								<div class="uploader employeeData">
									<div class="displayNone">
										<form>
											<input type="file" class="import-file">
										</form>
									</div>
									<div class="upload-import-update valign-wrapper">
										<p class="titleB01 grey-text w100p">Click here or drag file to upload</p>
									</div>
								</div>
							</div>
							<div class="col l12 center-align">
								<p class="mb20 mt20">
									<a href="#!" class="btn btnB01 mr5 prev-import">Back</a>
								</p>
							</div>
						</div>
					</li>
					<li>
						<div class="row">
							<div class="col l12 center-align h250 valign-wrapper mb20">
								<div class="valign w100p">
									<p class="titleB01 mt20">The file has been successfully uploaded!</p>
									<a href="#!" class="btn btnB01">finish</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="col l3 pad-t-20">
				<ul class="progress-indicator stacked">
		            <li class="completed">
		                <span class="bubble"></span>
		                <span class="stacked-text">
		                    Download
		                </span>
		            </li>
		            <li class="export">
		                <span class="bubble"></span>
		                <span class="stacked-text">
		                    Upload
		                </span>
		            </li>
		            <li>
		                <span class="bubble"></span>
		                <span class="stacked-text">
		                    finish
		                </span>
		            </li>
		        </ul>
			</div>
		</div>

	</div>
@endsection
