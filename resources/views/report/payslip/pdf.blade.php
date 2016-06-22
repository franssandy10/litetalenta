<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href='assets/css/stylePdf.css' rel='stylesheet' type='text/css'>

	<style type="text/css">
		table {
			width: 100%;
			font-family: sans-serif !important;
			border-collapse: collapse;
		}

		table.no-padding tr td {
			padding: 0 !important;
		}

		table.no-padding tr td p {
			margin-top: 0;
			margin-bottom: 0;
		}
	</style>
</head>
<body class="pad-20 pad-t-none">
	<table class="no-padding bBottom">
		<tr>
			<td colspan="2"><p class="bold">{{ App\Models\Company::find($result->userAccessConnection->company_id_fk)->name }}</p></td>
		</tr>
		<tr>
			<td colspan="2"><p class="bold">Februari 2016</p></td>
		</tr>
		<tr>
			<td width="15%">Employee Name</td>
			<td width="90%">: {{$result->first_name . ' ' . $result->last_name}}</td>
		</tr>
		<tr>
			<td>Employee ID</td>
			<td>: {{$result->employee_id}}</td>
		</tr>
		<tr>
			<td>Job Position</td>
			<td>: {{ $result->employeeJobPosition()->value('name').' - '. $result->employeeDepartment()->value('name')}}</td>
		</tr>
	</table>
    <!-- <table class="bBottom">
    	<tr>
    		<td class="mr10 pad-none" width="50%">{{$result->first_name." ".$result->last_name}}</td>
    		<td width="50%" class="ml10 pad-none"></td>
    	</tr>
    	<tr>
    		<td class="mr10 pad-none" width="50%">{{Sentinel::getUser()->userCompany->name}}</td>
    		<td width="50%" class="ml10 pad-none">Basic Salary: {{number_format($result->latestEmployeePayroll()->basic_salary,2,'.',',')}}</td>
    	</tr>
    	<tr>
    		<td class="mr10 pad-none" width="50%">Not Set | Employee ID: {{$result->employee_id}}</td>
    		<td width="50%" class="ml10 pad-none">Working Day: Not Set</td>
    	</tr>
    </table> -->
    <table class="bBottom">
		<tr>
			<td width="30%"><p class="bold">Salary</p></td>
			<td width="70%" style="vertical-align: top" class="no-padding">
    			<table class="mt5 mb5">
    				<tbody>
						<tr>
							<td>Basic Salary</td>
							<td class="right-align">{{number_format($result->latestEmployeePayroll()->basic_salary,2,'.',',')}}</td>
						</tr>
    				</tbody>
    			</table>
    		</td>
		</tr>
	</table>
	<table class="bBottom">
		<tr>
			<td width="30%" style="vertical-align: top"><p class="bold">Allowance</p></td>
			<td width="70%" style="vertical-align: top" class="no-padding">
    			<table class="striped mt5 mb5">
    				<tbody>
	    					@foreach($detailAllowance as $key =>$value)
	    					<tr>
		    					<td>{{ str_replace('_',' ',$key) }}</td>
								<td class="right-align">{{number_format($value,2,'.',',')}}</td>
							</tr>
	    					@endforeach
							<!-- <tr>
								<td>Tax Allowance</td>
								<td class="right-align">{{number_format($detail_payroll->tax_allowance,2,'.',',')}}</td>
							</tr>-->
		    				<tr class="grey">
		    					<td class="bold white-text pad-t-5 pad-b-5">Total Allowance</td>
		    					<td class="right-align bold white-text pad-t-5 pad-b-5">{{number_format($total['allowance'],2,'.',',')}}</td> 
		    				</tr>
    				</tbody>
    			</table>
    		</td>
		</tr>
	</table>

    <table class="">
    	<tbody>
	    	<tr class="bBottom">
	    		<td width="30%" style="vertical-align: top"><p class="bold">Deduction</p></td>
	    		<td width="70%" style="vertical-align: top" class="no-padding">
	    			<table class="striped mt5 mb5">
	    				<tbody>
	    					@foreach($detailDeduction as $key =>$value)
	    					<tr>
		    					<td>{{ str_replace('_',' ',$key) }}</td>
								<td class="right-align">{{number_format($value,2,'.',',')}}</td>
							</tr>
	    					@endforeach
		    				<tr class="grey">
		    					<td class="bold white-text pad-t-5 pad-b-5">Total Deduction</td>
		    					<td class="right-align bold white-text pad-t-5 pad-b-5">{{number_format($total['deduction'],2,'.',',')}}</td>
		    				</tr>
	    				</tbody>
	    			</table>
	    		</td>
	    	</tr>
	    	<tr class="grey mt30 bold white-text" style="border-top:1px solid #fff">
	    		<td>&nbsp;</td>
	    		<td class="pad-none">
	    			<table>
	    				<tr class="grey">
	    					<td>
				    			Take Home Pay
				    		</td>
				    		<td class="right-align">
	    						<p>{{number_format($total['takehomepay'],2,'.',',')}}</p>
				    		</td>
	    				</tr>
	    			</table>
	    		</td>
	    	</tr>
    	</tbody>
    </table>
</body>
</html>
