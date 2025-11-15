
<html>
    <head>
        <title>
            Mobile
        </title>
        <!-- <script src="https://cdn.socket.io/socket.io-1.0.0.min.js"></script> -->
        <script src="node_modules/socket.io/client-dist/socket.io.js"></script>
        <!-- <script type="text/javascript" src="https://cdn.socket.io/socket.io-3.0.5.min.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js" type="text/javascript"></script>
        <script>
          // var socket = io.connect('http://localhost:3000');
          // var socket = io.connect('http://localhost:8000', {secure: true});
            // var socket = io.connect('http://45.132.241.45:3000', {secure: true});
            var socket = io.connect('http://globalnewfriends.com:3000', {secure: true});
        </script>
    </head>
    <body>
        <input type="file" onchange="upload(this.files)" />
        <input type="button" name="act" id="push" value="message" />
        <input type="button" id="checkonline" value="Check Online" />
        <input type="button" id="callnow" value="Send Call" />
        <input type="button" id="calldecline" value="call decline" />
        <script type="text/javascript" charset="utf-8">
            window.addEvent('domready', function() {
                /*socket.on('connect', function() {
                   socket.emit('user_connected', user_id);
                });*/
                socket.emit('join_chat', {user_id: 5});
                $('push').addEvent('click', function() { 
                    socket.emit('send_message', { sender_id: 5,receiver_id: 3,message:"Hi i am developer..."});
                });
                $('checkonline').addEvent('click', function() { 
                    socket.emit('online', { user_id: 5}, (status) => {
                      console.log(status);
                    });
                });

                socket.on('receive_message', (status) => {
                  console.log(status);
                });
                socket.on('message_seen',(data)=>{
                    console.log(data);
                });
                $('callnow').addEvent('click', function() { 
                    socket.emit("send_call", { sender_id: 5,receiver_id: 3, channel_id : 123, calltype : 'audio'}, (status) => {
                        console.log(status);
                    });
                });
                socket.on('receive_call', (status) => {
                  console.log(status);
                });
                $('calldecline').addEvent('click', function() { 
                    socket.emit("send_calldecline", { sender_id: 5,receiver_id: 3, channel_id : 123}, (status) => {
                        console.log(status);
                    });
                });
                socket.on('receive_calldecline', (status) => {
                  console.log(status);
                });
            });
            function upload(files) {
                var file = files[0];
                // var filename = file.name;
                var filename = '.png';
                var filetype = 'image';
                socket.emit("send_media", { sender_id: 5,receiver_id: 3, file : file, name : filename, filetype : filetype}, (status) => {
                    console.log(status);
                });
            }
        </script>
    </body>
</html>