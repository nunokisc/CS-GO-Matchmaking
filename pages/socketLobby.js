var http = require("http").createServer(servidor);
var io = require("socket.io").listen(http);
var fs = require("fs");

var usuarios = 0;

function servidor(req, res){
	res.writeHead(200);
	//res.end(fs.readFileSync("index.php"));
}

var timeToPick;

function randomPickFuncion(msg) {
	var runner = require("child_process");
	var phpScriptPath = "vetoRand_proc.php";
	var argsString = msg.lobbyId;

	runner.exec("php " + phpScriptPath + " " +argsString, function(err, phpResponse, stderr) {
	if(err) console.log(err); /* log error */
		console.log( phpResponse );
	});

		console.log(msg.trigger);
		io.to(msg.lobbyId).emit("update", msg);
		if(msg.trigger <= 6){
			timeToPick = setTimeout(randomPickFuncion, 30000, msg);
		}
		msg.trigger ++;
	console.log("Random Veto Done!");
}

io.on("connection", function(socket){
	socket.join(socket.handshake.query.lobby);
	console.log("Usuário Conectado ao lobby: ", socket.handshake.query.lobby);
	usuarios++;
	console.log("Estao ",usuarios);
	
	socket.on("update", function(msg){
		io.to(msg).emit("update", msg);
		console.log("Update no lobby: ", msg);
	});
	
	socket.on("status", function(msg){
		console.log(socket.adapter.rooms);
	});
	
	socket.on("startVeto", function(msg){
		timeToPick = setTimeout(randomPickFuncion, 30000, msg);
		console.log("Timer Random Veto starts");
	});
	
	socket.on("veto", function(msg){
		clearTimeout(timeToPick);
		if(msg.trigger <= 6){
		timeToPick = setTimeout(randomPickFuncion, 30000, msg);
		}
		console.log("Random Veto reset and start again");
	});

	socket.on("disconnect", function(){
		console.log("Usuario Desconectado");
		usuarios--;
	});
});


http.listen(4000);