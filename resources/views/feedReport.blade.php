<!DOCTYPE html>
<html>
<head>
    <title>Visitor Entry Report</title>
    <style type="text/css">
      .wrap{
         word-wrap: break-word;
         width: 15%;
      }
    </style>
	
</head>
<body>
	
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
    			<td style="text-align:center;"style="text-align:center;"></td>
    			<td style="text-align:center;"style="text-align:center;"></td>
          <td style="text-align:center;"><?php if($data['entryFeed']->date_time){echo date('d-m-Y H:i:s',strtotime($data['entryFeed']->date_time));} ?></td>  
    			<td class="wrap"><?php if($data['entryFeed']->license_plate_number){ echo $data['entryFeed']->license_plate_number;} ?></td>
    			<td style="text-align:center;"style="text-align:center;"><?php if($data['entryFeed']->images){ ?>
            <img src="{{asset('public/uploads/feed_image')}}<?php echo'/'.$data['entryFeed']->images.'.jpeg';?>" height="100" width="200"><?php }?>
          </td>
    			<td style="text-align:center;"style="text-align:center;"></td>
    			<td style="text-align:center;"style="text-align:center;"></td>
    			<td style="text-align:center;"style="text-align:center;"></td>
    			<td style="text-align:center;"style="text-align:center;"></td>
    			<td style="text-align:center;"style="text-align:center;"></td>
    			
    		</tr>
    		<?php $i++; ?>
    		@endforeach

    	</tbody>
    </table>   

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
