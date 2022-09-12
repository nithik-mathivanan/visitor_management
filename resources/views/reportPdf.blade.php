<!DOCTYPE html>
<html>
<head>
    <title>Visitor Entry Report</title>
    <style type="text/css">
      .wrap{
         word-wrap: break-word;
         width: 15%;
      }
      .page{
        page-break-after: always;
      }
    </style>
	
</head>
<body>
	<div class="page">
    <h3>Location Name: <?php echo $location_name; ?></h3><br>
    <div class="row">
    	<div class="col-md-2">
    		<p>No of visitor:<?php echo count($entry_report); ?></p>
    	</div>
    	
    	<div class="col-md-2">
    		
    	</div>
    	<div class="col-md-2">
    		
    	</div>
    </div> 
    <table border="1px" style="table-layout:fixed;width: 100%;">
      
    	<thead style="background-color: #555a64;color: white;">
    		<th style="width:5%;">S.No</th>
    		<th style="width:10%;">Name</th>
    		<th style="width:12%;">Mobile No</th>
        <th style="width:9%;">Date Time</th>
    		<th style="width:10;">Vehicle No</th>
    		<th style="width:24%;">Car Plate Image</th>
    		<th style="width:5%;">Unit Visited</th>
    		<th style="width:7%;">In Time</th>
    		<th style="width:7%;">Out Time</th>
    		<th style="width:8%;">Purpose of Visit</th>
    		<th style="width:7%;">IC no</th>
    		
    	</thead>
    	<tbody>
    		<?php $i=1;?>
    		@foreach($entry_report as $data)
    		<tr>
    			<td style="text-align:center;"style="text-align:center;">{{$i}}</td>
    			<td style="text-align:center;"style="text-align:center;">{{$data->getVisitor->visitor_name}}</td>
    			<td style="text-align:center;"style="text-align:center;">{{$data->getVisitor->mobile}}</td>
          <td style="text-align:center;"><?php  echo date('d-m-Y H:i:s',strtotime($data->created_at));?></td>  
    			<td class="wrap"><?php echo $data->vehicle_no; ?></td>
    			<td style="text-align:center;"style="text-align:center;">@if($data->entryFeed)<img src="{{asset('public/uploads/feed_image')}}<?php echo'/'.$data->entryFeed->images.'.jpeg';?>" height="100" width="200">@endif</td>
    			<td style="text-align:center;"style="text-align:center;"><?php echo $data->unit_no; ?></td>
    			<td style="text-align:center;"style="text-align:center;"><?php echo date('H:i:s',strtotime($data->in_time));?></td>
    			<td style="text-align:center;"style="text-align:center;"><?php echo date('H:i:s',strtotime($data->out_time));?></td>
    			<td style="text-align:center;"style="text-align:center;"><?php if($data->visitReason!=null){echo $data->visitReason->purpose;}?></td>
    			<td style="text-align:center;"style="text-align:center;">{{$data->ic_number}}</td>
    			
    		</tr>
    		<?php $i++; ?>
    		@endforeach
    	</tbody>
    </table>
    </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<