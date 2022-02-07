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
                            <h2 style="font-family: 'Poppins', sans-serif;font-size:24px;text-align:center;margin-bottom:40px;">Thank You</h2>
                            <p style="font-family: 'Poppins', sans-serif;font-size:16px;">Hello, <strong>{{ $data['name'] }}</strong></p>
                            <p style="font-family: 'Poppins', sans-serif;font-size:16px;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
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
