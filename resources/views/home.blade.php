<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recent Feeds</title>
</head>
<body>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">                  
                    <h4>The Brownstone</h4>
                    <table border="1">
                        <thead>
                            <th>location_id</th>
                            <th>location_name</th>
                            <th>feed_id</th>
                            <th>feed_name</th>
                           
                            <th style="background-color: yellow;">Vision Spectra date time</th>
                            <th style="background-color: yellow;">DB Date Time</th>
                            <th>license_plate_number</th>
                        </thead>
                        <tbody>
                            @foreach($brownstone as $value)
                            <tr>
                                <td>{{$value->location_id}}</td>
                                <td>{{$value->location_name}}</td>
                                <td>{{$value->feed_id}}</td>
                                <td>{{$value->feed_name}}</td>
                                
                                <td style="background-color: yellow;">{{$value->date_time}}</td>
                                <td style="background-color: yellow;">{{$value->Created_at}}</td>
                                <td>{{$value->license_plate_number}}</td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4>The Rivervale</h4>
                    <table border="1">
                        <thead>
                           <th>location_id</th>
                            <th>location_name</th>
                            <th>feed_id</th>
                            <th>feed_name</th>
                            
                            <th style="background-color: yellow;">Vision Spectra date time</th>
                            <th style="background-color: yellow;">DB Date Time</th>
                            <th>license_plate_number</th>
                        </thead>
                        <tbody>
                            @foreach($rivervale as $value)
                            <tr>
                                <td>{{$value->location_id}}</td>
                                <td>{{$value->location_name}}</td>
                                <td>{{$value->feed_id}}</td>
                                <td>{{$value->feed_name}}</td>
                          
                                <td style="background-color: yellow;">{{$value->date_time}}</td>
                                <td style="background-color: yellow;">{{$value->Created_at}}</td>
                                <td>{{$value->license_plate_number}}</td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4>The Tembusu</h4>
                   <table border="1">
                        <thead>
                            <th>location_id</th>
                            <th>location_name</th>
                            <th>feed_id</th>
                            <th>feed_name</th>
                          
                            <th style="background-color: yellow;">Vision Spectra date time</th>
                            <th style="background-color: yellow;">DB Date Time</th>
                            <th>license_plate_number</th>
                        </thead>
                        <tbody>
                            @foreach($tembusu as $value)
                            <tr>
                                <td>{{$value->location_id}}</td>
                                <td>{{$value->location_name}}</td>
                                <td>{{$value->feed_id}}</td>
                                <td>{{$value->feed_name}}</td>
                              
                                <td style="background-color: yellow;">{{$value->date_time}}</td>
                                <td style="background-color: yellow;">{{$value->Created_at}}</td>
                                <td>{{$value->license_plate_number}}</td>                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4>The Trillium</h4>
                    <table border="1">
                        <thead>
                            <th>location_id</th>
                            <th>location_name</th>
                            <th>feed_id</th>
                            <th>feed_name</th>
                            <th style="background-color: yellow;">Vision Spectra date time</th>
                            <th style="background-color: yellow;">DB Date Time</th>
                            <th>license_plate_number</th>
                        </thead>
                        <tbody>
                            @foreach($trillium as $value)
                            <tr>
                                <td>{{$value->location_id}}</td>
                                <td>{{$value->location_name}}</td>
                                <td>{{$value->feed_id}}</td>
                                <td>{{$value->feed_name}}</td>
                                <td style="background-color: yellow;">{{$value->date_time}}</td>
                                <td style="background-color: yellow;">{{$value->Created_at}}</td>
                                <td>{{$value->license_plate_number}}</td>                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


