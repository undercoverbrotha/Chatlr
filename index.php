<!doctype html>
<html>
  <head>
    <title>socket.io client test</title>
        
    <script src="/json.js"></script> <!-- for ie -->
    <script src="http://tumblrchat.loc:8080/socket.io/socket.io.js"></script>
  </head>
  <body>
    
    <script>
      function message(obj){
        var el = document.createElement('p');
        if ('announcement' in obj) el.innerHTML = '<em>' + esc(obj.announcement) + '</em>';
        else if ('message' in obj) el.innerHTML = '<b>' + esc(obj.message[0]) + ':</b> ' + esc(obj.message[1]);
        document.getElementById('chat').appendChild(el);
        document.getElementById('chat').scrollTop = 1000000;
      }
      
      function send(){
        var val = document.getElementById('text').value;
        socket.send(val);
        message({ message: ['you', val] });
        document.getElementById('text').value = '';
      }
      
      function esc(msg){
        return msg.replace(/</g, '&lt;').replace(/>/g, '&gt;');
      };
      
      var socket = new io.Socket(null, {port: 8080});
      socket.connect();
      socket.on('message', function(obj){
        if ('buffer' in obj){
          document.getElementById('form').style.display='block';
          document.getElementById('chat').innerHTML = '';
          
          for (var i in obj.buffer) message(obj.buffer[i]);
        } else message(obj);
      });
    </script>
    
    <h1>Sample chat client</h1>
    <div id="chat"><p>Connecting...</p></div>
    <form id="form" onsubmit="send(); return false">
      <input type="text" autocomplete="off" id="text"><input type="submit" value="Send">
    </form>
    
    <style>
      #chat { height: 300px; overflow: auto; width: 800px; border: 1px solid #eee; font: 13px Helvetica, Arial; }
      #chat p { padding: 8px; margin: 0; }
      #chat p:nth-child(odd) { background: #F6F6F6; }
      #form { width: 782px; background: #333; padding: 5px 10px; display: none; }
      #form input[type=text] { width: 700px; padding: 5px; background: #fff; border: 1px solid #fff; }
      #form input[type=submit] { cursor: pointer; background: #999; border: none; padding: 6px 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; margin-left: 5px; text-shadow: 0 1px 0 #fff; }
      #form input[type=submit]:hover { background: #A2A2A2; }
      #form input[type=submit]:active { position: relative; top: 2px; }
    </style>
    
  </body>
</html>