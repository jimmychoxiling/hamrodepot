<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{ $data['subject'] }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body class="">
        <div style="width:500px;max-width:100%;margin:0px auto;">
            <table style="width:100%;border:1px solid #e3e3e3;" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <td>
                            <a href="" style="display:inline-block;width:100%;text-align:center;background-color:#e3e3e3;padding:20px 15px;box-sizing:border-box;"><img style="display:inline-block;width:100px;" src="{{asset('images/logo.png')}}"></a>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left:15px;padding-right:15px;padding-top:30px;padding-bottom:30px;">
                            <h2 style="font-family: 'Poppins', sans-serif;font-size:24px;text-align:center;margin-bottom:30px;">Service Request</h2>
                            <table style="width:100%;border:1px solid #ddd;" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;width:165px;padding:10px 10px;background-color:#ddd;border-right:1px solid #fff;">Full Name:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;background-color:#ddd;">{{ $data['name'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;">Email:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;">{{ $data['sender_email'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;background-color:#ddd;border-right:1px solid #fff;">Phone Number:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;background-color:#ddd;">{{ $data['phone'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;">Address:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;">{{ $data['address'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;background-color:#ddd;border-right:1px solid #fff;">State:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;background-color:#ddd;">{{ $data['state'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;">City:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;">{{ $data['city'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;background-color:#ddd;border-right:1px solid #fff;">Zip Code:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;background-color:#ddd;">{{ $data['zipcode'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;width:165px;padding:10px 10px;">Service:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;">{{ $data['service'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;width:165px;padding:10px 10px;background-color:#ddd;border-right:1px solid #fff;">Service Date:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;background-color:#ddd;">{{ $data['service_date'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;">Description:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;">{{ $data['description'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;background-color:#ddd;border-right:1px solid #fff;">Time:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;background-color:#ddd;">{{ $data['time'] ?? '-' }}</td>
                                    </tr>
                                    <!-- <tr>
                                        <th style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;width:165px;">Budget:</th>
                                        <td style="font-family: 'Poppins', sans-serif;text-align:left;padding:10px 10px;">{{ config('constant.CURRENCY_SIGN') }}{{ $data['budget'] ?? '-' }}</td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <ul style="list-style:none;display:inline-block;width:100%;text-align:center;padding:0px;margin:0px;background-color:#e3e3e3;box-sizing:border-box;padding:15px 0px;">
                                <li style="margin-right:7px;display:inline-block;"><a href="" style="display:inline-block;text-align:center;line-height:32px;width:26px;height:26px;border-radius:50%;background-color:#000;"> <img style="display:inline-block;width:15px;he
                                auto;" src="{{ asset('image/social/facebook.png') }}"></a></i></a></li>
                                <li style="margin-right:7px;display:inline-block;"><a href="" style="display:inline-block;text-align:center;line-height:32px;width:26px;height:26px;border-radius:50%;background-color:#000;"> <img style="display:inline-block;width:15px;he
                                auto;" src="{{ asset('image/social/instagram.png') }}"></a></i></a></li>
                                <li style="margin-right:7px;display:inline-block;"><a href="" style="display:inline-block;text-align:center;line-height:32px;width:26px;height:26px;border-radius:50%;background-color:#000;"> <img style="display:inline-block;width:15px;he
                                auto;" src="{{ asset('image/social/linkedin.png') }}"></a></i></a></li>
                                <li style="margin-right:7px;display:inline-block;"><a href="" style="display:inline-block;text-align:center;line-height:32px;width:26px;height:26px;border-radius:50%;background-color:#000;"> <img style="display:inline-block;width:15px;he
                                auto;" src="{{ asset('image/social/twitter.png') }}"></a></i></a></li>
                            </ul>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>
