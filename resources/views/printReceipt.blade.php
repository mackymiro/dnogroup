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
        <h1 style="text-align:left; font-size:5px; "><u>LOLO PINOY GRILL {{ $branch}} Branch</u></h1>
		<br>
		<p style="text-align:left; font-size:5px;  margin-top:-20px">
		   TIN No: 226-369-910-002
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
			Senior Citizen: 
			<br>
			Senior Citizen Name: 
		</p>
		<table style="margin-left:1px; font-size:5px;">
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; ">QTY</th>	
				<th style=" text-align:left; font-size:5px;">Item</th>
				<th style=" text-align:left; font-size:5px;">Amount</th>
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; ">{{ $getBranchItem[0]->qty}}</th>	
				<th style=" text-align:left; font-size:5px;">{{ $getBranchItem[0]->item_description}}</th>
				<th style=" text-align:left; font-size:5px;"><?php echo number_format($getBranchItem[0]->amount, 2); ?></th>
			</tr>
			@foreach($getOtherItems as $getOtherItem)
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; ">{{ $getOtherItem->qty}}</th>	
				<th style=" text-align:left; font-size:5px;">{{ $getOtherItem->item_description}}</th>
				<th style=" text-align:left; font-size:5px;"><?php echo number_format($getOtherItem->amount, 2); ?></th>
			</tr>
			@endforeach
		</table>
		<br>
		<br>
		<br>
		<table style="width:80%; margin-left:1px; font-size:5px;">
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">Total</th>	
				<th style="text-align:left; font-size:5px;"></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">Cash</th>	
				<th style="text-align:left; font-size:5px;"></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">Senior</th>	
				<th style="text-align:left; font-size:5px;"></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px;" width="30%">Gift Cert</th>	
				<th style="text-align:left; font-size:5px;"></th>
				
			</tr>
			<tr style="border:1px solid black;">
				<th style="text-align:left; font-size:5px; " width="30%">Change</th>	
				<th style="text-align:left; font-size:5px;"></th>
				
			</tr>
		
		</table>
	
    </div>
    <div>
        
    </div>
</div>