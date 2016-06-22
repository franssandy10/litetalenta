@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
@endsection
@section('content')
	<div class="container mt30">
		<p class="lato-black f24">Payroll Configuration</p>
		<p class="lato-boldItalic mt5">Configure your payroll to start using our payroll features</p>

		<div class="row mt30">
			<div class="col l12">
				<div class="disabledWarningDiv displayBlock">
					<div class="col l1 center-align">
						<img src="{{asset('assets/images/warning1.png')}}" class="responsive-img">
					</div>
					<div class="col l10">
						<p>Steps 1 - 3 are mandatory, these steps can not be skipped. If you don't need to set <strong class="lato-black">Payroll Component, Prorate, Absence, and THR</strong> you can proceed by clicking skip button for each item and can set them later in <strong class="lato-black">Setting > Payroll Configuration</strong></p>
					</div>
				</div>
			</div>
		</div>

		<div class="row h-tabRow ml0 mr0">
			<div class="col s2">
				<ul id="step">
					<li class="active">
						<i class="talenta-payroll-details"></i>
						Payroll<br>Details
					</li>

					<li>
						<i class="talenta-kalender-2"></i>
						Cut Off
					</li>
					<li>
						<i class="talenta-komponen"></i>
						Payroll<br>Component
					</li>
				</ul>
			</div>
			<div class="col s10 white h-tabRow">
				<div class="col s12 tab-content">
					<div class="row mt20">
						<div class="col s12">
							<p class="titleB01" id="titlePage">Payroll Details</p>
				    		<p class="subtitleA01" id="stepTitle">step <span>1</span></p>
						</div>
					</div>
					<div class="content">
						<div class="row partial">
							@include('payroll.partial.detail',['tax_person'=>$tax_person])
							<div class="row">
								<div class="col s12 mt30 right-align">
									<a href="#!" class="btn btn02 next">Next</a>
								</div>
							</div>
						</div>

						<div class="row partial" data-title="Payroll Cutoff">
							@include('payroll.partial.cutoff')
							<div class="row">
								<div class="col s12 mt30 right-align">
									<a href="#!" class="btn btn02 next">Next</a>
								</div>
							</div>
      			</div>

						<div class="row partial" data-title="Payroll Component">
							@include('payroll.partial.component')
							<div class="row">
								<div class="col s12 mt30 right-align">
									<a href="#!" class="btn btn02 next">Next</a>
									<a href="#!" class="linkB01">Skip this step</a>
								</div>
							</div>
						</div>

						<!-- <div class="partial" data-title="Pro-rate">
								@include('payroll.partial.prorate')
								<div class="row">
									<div class="col s12 mt30 right-align">
										<a href="#!" class="btn btn02 next">Next</a>
										<a href="#!" class="linkB01">Skip this step</a>
									</div>
								</div>
							</div>
							<div class="partial" data-title="Absence">
								@include('payroll.partial.absence')
								<div class="row">
									<div class="col s12 mt30 right-align">
										<a href="#!" class="btn btn02 next">Next</a>
										<a href="#!" class="linkB01">Skip this step</a>
									</div>
								</div>
							</div>
							<div class="partial" data-title="THR">
								@include('payroll.partial.thr')
								<div class="row">
									<div class="col s12 mt30 right-align">
										<a href="#!" class="btn btn02 next">Next</a>
										<a href="#!" class="linkB01">Skip this step</a>
									</div>
								</div>
							</div> -->
					</div><!-- content -->
				</div><!-- tab content -->
			</div><!-- h-tabrow -->
		</div><!-- h-tabRow ml0 mr0 -->
	</div>
@include('payroll.component.create-modal')
@endsection
@section('customCss')
	<style type="text/css">
		.h-tabRow > .col.s2 > ul {
			padding: 30px 0;
		}

		.h-tabRow > .col.s2 > ul > li {
			text-align: center;
		    font-family: 'lato-bold';
		    font-size: 14px;
		    color: #A3A3A3;
		}

		.h-tabRow > .col.s2 > ul > li.active {
			color: #5C2F36;
		}

		.h-tabRow > .col.s2 > ul > li:not(:first-child):before{
			content: '▼';
		}

		.h-tabRow > .col.s2 > ul > li:not(:last-child) {
			margin: 5px 0;
		}

		.h-tabRow > .col.s2 > ul > li > i {
			font-size: 35px;
			margin: 5px 0 10px;
		}

		.col.s10.white.h-tabRow {
			min-height: 856px;
		}

		.partial:not(:first-child) {
			display: none;
		}

		.partial .linkB01 {
			margin: 10px 10px 0;
		}
	</style>

@endsection
@section('customjs')
@yield('createcompjs')
<script type="text/javascript">
	$(document).ready(function(){

		$('.next').click(function(){
			$form=$(this).parents  ('.row.partial').find('form');
			validateForm($form);
			console.log(flagAjax);
			if(flagAjax==true){
				next()
			}
		})

		$('.prev').click(function(){
			prev()
		})

	})

	function prev(){
		$('.partial:visible').each(function(){
			var first = $(this).is(':first-child');
			var prev = $(this).prev();
			if ($(this).is(':visible') && first == false) {
				$(this).hide("slide", { direction: "down" }, 300);
				setTimeout(function(){
					prev.show("slide", { direction: "up" }, 300);
				}, 300);
				if ($(this).height() > prev.height()){
					$("html, body").animate({ scrollTop: "230px" });
				}
			}
			var current = parseInt($('.partial').index($(this)));
			$('#stepTitle span').text(current)
			$('#titlePage').text(prev.data('title'));
			coloring(current);
		})
	}

	function next(){
		$('.partial:visible').each(function(){
			var last = $(this).is(':last-child');
			var next = $(this).next();
			if ($(this).is(':visible') && last == false) {

				$(this).hide("slide", { direction: "up" }, 300);
				setTimeout(function(){
					next.show("slide", { direction: "down" }, 300);
				}, 300)
				if ($(this).height() > next.height()){
					$("html, body").animate({ scrollTop: "230px" });
				}
			}
			var current = parseInt($('.partial').index($(this))) + 2;
			$('#stepTitle span').text(current)
			$('#titlePage').text(next.data('title'));
			coloring(current);
		})
	}

	function coloring(current){
		var length = $('#ul li').length;
		$('ul#step li').removeClass('active');
		for (var i=0;i<=current;i++) {
			$('ul#step li:nth-child(' + i + ')').addClass('active');
		}
	}
</script>
@endsection
