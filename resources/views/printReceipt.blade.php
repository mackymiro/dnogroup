<style type="text/css">
	table{
		border-collapse: collapse;
		width:76%;
		margin:0 auto;
	}
	table, td, th{
		font-size:12px;
	}
	
	p{
		text-align:center;
		font-size:10px;
	}


	h4{
		text-align:center;

	}

</style>
<div style="width:76px;">
    <div style="margin-left:-40px; margin-top:-40px;">
        <h1 style="text-align:left; font-size:5px; "><u>Ribos Food Corporation</u></h1>
		<p style="text-align:left; font-size:5px; "><u>LOLO PINOY GRILL {{ $branch}} Branch</u></p>
		<br>
		<p style="text-align:left; font-size:5px;  margin-top:-20px">
		   TIN No: 226-369-910-002
		   <br>
			Date: <?= date("Y-m-d"); ?>
		   <br>
			Cashier Name: {{ $getBranchItem[0]->created_by }}
			<br>
			Invoice Number: {{ $getBranchItem[0]->invoice_number }}
			<br>
			Ordered By: {{ $getBranchItem[0]->ordered_by }}
			<br>
			Table NO: {{ $getBranchItem[0]->table_no }}
			<br>
			Transaction ID: {{ $getBranchItem[0]->id }}
			<br>
			@if($getBranchItem[0]->senior_citizen_label != NULL)
				Senior Citizen ID: {{ $getBranchItem[0]->senior_citizen_id }}
				<br>
				Senior Citizen Name: {{ $getBranchItem[0]->senior_citizen_name }}
			@endif
		</p>
		<table style="margin-left:-3px; font-size:2px; width:100px;">
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; width:10px; ">Qty</th>	
				<th style=" text-align:left; font-size:5px; width:10px">Item</th>
				<th style=" text-align:left; font-size:5px;">Amount</th>
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; ">{{ $getBranchItem[0]->qty}}</th>	
				<th style=" text-align:left; font-size:5px;">{{ $getBranchItem[0]->item_description}}
					@if($getBranchItem[0]->flavor != "NULL")
						- {{ $getBranchItem[0]->flavor }}
					@endif
				</th>
				<th style=" text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->amount, 2); ?></th>
			</tr>
			@foreach($getOtherItems as $getOtherItem)
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; ">{{ $getOtherItem->qty}}</th>	
				<th style=" text-align:left; font-size:5px;">{{ $getOtherItem->item_description}}
					@if($getOtherItem->flavor != "NULL")
						- {{ $getOtherItem->flavor }}
					@endif
				</th>
				<th style=" text-align:left; font-size:5px;"><?= number_format($getOtherItem->amount, 2); ?></th>
			</tr>
			@endforeach
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="60%">Sub Total: </th>	
				<th style="text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->total_amount_of_sales, 2)?></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="0%">Total: </th>	
				<th style="text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->total, 2)?></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">Cash: </th>	
				<th style="text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->cash_amount, 2)?></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="60%">Senior Discount: </th>	
				<th style="text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->senior_amount, 2)?></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px;" width="60%">Gift Cert: </th>	
				<th style="text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->gift_cert, 2)?></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">Change: </th>	
				<th style="text-align:left; font-size:5px;"><?= number_format($getBranchItem[0]->change, 2)?></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">SC: </th>	
				<th style="text-align:left; font-size:5px;">__________________</th>
				
			</tr>
		
		</table>
		<br>
		<div style="clear:both"></div>
		
    </div>
	
</div>