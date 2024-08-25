<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>Reunión de Zoom: {{ $meeting['topic'] }}</h1>
    
        <div id="zmmtg-root"></div>
    
        <script src="https://source.zoom.us/2.18.6/lib/vendor/react.min.js"></script>
        <script src="https://source.zoom.us/2.18.6/lib/vendor/react-dom.min.js"></script>
        <script src="https://source.zoom.us/2.18.6/lib/vendor/redux.min.js"></script>
        <script src="https://source.zoom.us/2.18.6/lib/vendor/redux-thunk.min.js"></script>
        <script src="https://source.zoom.us/2.18.6/lib/vendor/lodash.min.js"></script>
    
        <script src="https://source.zoom.us/zoom-meeting-2.18.6.min.js"></script>
    
        <script>
            ZoomMtg.setZoomJSLib('https://source.zoom.us/2.18.6/lib', '/av'); // Configura la librería
    
            ZoomMtg.preLoadWasm();
            ZoomMtg.prepareJssdk();
    
            ZoomMtg.init({
                leaveUrl: "{{ url('/') }}",
                success: function () {
                    ZoomMtg.join({
                        signature: "{{ $signature }}", // Necesitarás generar esta firma en tu backend
                        meetingNumber: "{{ $meeting['id'] }}",
                        userName: "Nombre de Usuario",
                        apiKey: "{{ env('ZOOM_CLIENT_ID') }}",
                        userEmail: "correo@ejemplo.com", // Opcional
                        passWord: "{{ $meeting['password'] }}", // Opcional
                        success: function(res){
                            console.log('join meeting success');
                        },
                        error: function(res) {
                            console.log(res);
                        }
                    });
                },
                error: function(res) {
                    console.log(res);
                }
            });
        </script>
    </div>
</body>
</html>