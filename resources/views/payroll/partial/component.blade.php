<div class="col l12">
	<table class="bordered" id="payrollComponentTable">
		<tr class="bgRed1 white-text bold">
			<td class="center-align bLeft" width="50%">Allowance</td>
			<td class="center-align" width="50%">Deductions</td>
			<!-- <td class="center-align bRight" width="33.3%">Benefits</td> -->
		</tr>
		<tr>
			<!-- untuk urlnya pake ajax post ya url route('payrollcomponent.delete',['id'=>$id]) -->
			<td class="bRight bLeft componentWrapperColumn valign-top" data-type="allowance">
				@foreach($component_allowance as $component)
				<div class="grey lighten-3 pad-10 displayInlineBlock maxWidth100p mr5 componentWrapper" data-view="{{route('payrollcomponent.detail', ['id'=>$component->id])}}" data-tooltip="{{$component->component_name}}">
					<p class="left mr5 truncate">{{$component->component_name}}</p>
					<a data-url="{{route('payrollcomponent.delete',['id'=>$component->id])}}" class="right grey-text cursorPointer bold delComponent"><i class="fa fa-times"></i></a>
				</div>
				@endforeach
			</td>
			<td class="bRight componentWrapperColumn valign-top" data-type="deduction">
				@foreach($component_deduction as $component)
				<div class="grey lighten-3 pad-10 displayInlineBlock maxWidth100p mr5 componentWrapper" data-view="{{route('payrollcomponent.detail', ['id'=>$component->id])}}" data-tooltip="{{$component->component_name}}">
					<p class="left mr5 truncate">{{$component->component_name}}</p>
					<a data-url="{{route('payrollcomponent.delete',['id'=>$component->id])}}" class="right grey-text cursorPointer bold delComponent"><i class="fa fa-times"></i></a>
				</div>
				@endforeach
			</td>
			<!-- <td class="bRight"></td> -->
		</tr>
		<tr>
			<td class="center-align bRight bLeft"><a href="#modalCreatePayrollComponent" data-type="allowance" class="red1-text modal-trigger"><i class="fa fa-plus-circle"></i> Add Allowance</a></td>
			<td class="center-align bRight"><a href="#modalCreatePayrollComponent" class="red1-text modal-trigger" data-type="deduction"><i class="fa fa-plus-circle"></i> Add Deduction</a></td>
			<!-- <td class="center-align bRight"><a href="#!" class="red1-text"><i class="fa fa-plus-circle"></i> Add Benefit</a></td> -->
		</tr>
	</table>
</div>
