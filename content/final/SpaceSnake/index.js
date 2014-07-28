var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var path = require('path');

app.use(express.static(path.join(__dirname,'public')));

var Games = [];
var totalNumPlayers = 0;
var GAME_START_FPS = 20;
var MAX_NUM_PLAYERS = 20;

io.on('connection', function(socket){
    console.log("connected...sock id");
    console.log(socket.id);
    io.emit('connected', socket.id);

    socket.on('chat message', function(msg) {
	io.emit('chat message', msg);
    });

    socket.on('create player', function(data) {
	player = {
                 id: data.id && data.id != undefined ? data.id : "anon"+((Math.random() * 1000) | 0),
                 color: data.color,
                 score: 0,
                 positions: [[-1,-1]],
                 direction: "N",
                 sockId: socket.id
        };
	totalNumPlayers++;
	io.emit('playerCreated', player);
    });

    socket.on('findGames', function() {
	var game = {
	    id: ((Math.random() * 10000) | 0),
	    players: [],
	    chat: [],
	    food: [[ Math.floor( (Math.random() * GAME_WIDTH) + 1), Math.floor( (Math.random() * GAME_HEIGHT) + 1)]],
	    FPS: GAME_START_FPS	    
	};
	if( Games.length == 0 ) {
	    Games.push( game );
	    console.log("Game added.");
	} else {
	    var allGamesFull = true;
	    Games.forEach( function(entry) {
		if( entry.players.length < MAX_NUM_PLAYERS ) allGamesFull = false;
	    });
	    if( allGamesFull ) {
		Games.push( game );
		console.log("Another Game added.");
		allGamesFull = false;
	    }
	}
	gameIDs = [];
	Games.forEach( function(entry) {
	    if( entry.players.length < 10 ) gameIDs.push( entry.id ); 
	});
	io.emit('showGames', gameIDs);
    });

    socket.on('enter room', function(data) {
	console.log("Entering Game #"+data.id);
	Games.forEach( function(entry) {
	    if( entry.id == data.id ) {
		console.log(entry);
		data.player.positions[0] = setNewPlayerPosition(entry);
		data.player.sockId = socket.id;
		entry.players.push(data.player);
		io.emit('display game', entry);		
	    }
	});
    });

    socket.on('game update', function(data) {
	Games.forEach( function(entry) {
	    if(entry.id == data.game.id) {
		for(var i = 0; i < entry.players.length; ++i) {
		    p = entry.players[i];
		    if(p.id == data.player.id) {
			p.direction = data.player.direction;
			update(data.player, entry);
			entry.players[i] = data.player;
			io.emit('display game', entry);
		    }
		}
	    }
	});
    });

    socket.on('logout', function(data) {
	console.log(data.player);
	console.log('has logged out of');
	console.log(data.game);
	Games.forEach( function(entry) {
	    if( entry.id == data.game.id ) {
		for(var i = 0; i < entry.players.length; ++i) {
		    if( entry.players[i].id == data.player.id ) {
			entry.players.splice(i,1);
			io.emit('display game', entry);
			socket.disconnect();
		    }
		}
	    }
	});
    });
    
    socket.on('disconnect', function() {
	console.log('Player disconnecting...');
	Games.forEach( function(entry) {
	    for( var i = 0; i < entry.players.length; ++i ) {
		if( entry.players[i].sockId == socket.id ) {
		    entry.players.splice(i,1);
		    io.emit('display game', entry);
		}
	    }
	});
    });

    socket.on('reset players', function(data) {
	var oldGame;
	Games.forEach( function(entry) {
	    if( entry.id == data.id ) oldGame = entry;
	});
	
    });

});

var GAME_WIDTH = 29;
var GAME_HEIGHT = 14;

function update(player, game) {
    var oldPos = player.positions[0];

    if( player.direction == "N" && player.positions[0][1] > 0 ) {
	if( !collisionCheck([player.positions[0][0], player.positions[0][1] - 1], game) ) player.positions[0][1]--;
    } else if( player.direction == "S" && player.positions[0][1] < GAME_HEIGHT ){
	if( !collisionCheck([player.positions[0][0], player.positions[0][1] + 1], game) ) player.positions[0][1]++;
    } else if( player.direction == "E" && player.positions[0][0] < GAME_WIDTH ) {
	if( !collisionCheck([player.positions[0][0]+1, player.positions[0][1]], game) ) player.positions[0][0]++;
    } else if( player.direction == "W" && player.positions[0][0] > 0 ) {
	if( !collisionCheck([player.positions[0][0]-2, player.positions[0][1]], game) ) player.positions[0][0]--;
    }

    var hasEaten = false;

    if( player.positions[0][0] == game.food[0][0] && player.positions[0][1] == game.food[0][1] ) {
	player.score++;
	hasEaten = true;
	game.food[0] = setNewPlayerPosition(game);
    }

    if( player.positions.length > 1 ) {
	for( var i = 1; i < player.positions.length; ++i ) {
	    var tmp = player.positions[i];
	    player.positions[i] = oldPos;
	    oldPos = tmp;
	}
    }

    if( hasEaten ) {
	player.positions[player.positions.length] = [oldPos[0], oldPos[1]];
    }

}

function collisionCheck( pos, game ) {
    var collided = false;
    game.players.forEach( function(p) {
	for( var i = 0; i < p.positions.length; ++i ) {
	    var position = p.positions[i];
	    if( pos[0] == position[0] && pos[1] == position[1] ) {
		collided = true;
	    }
	}
    });
    return collided;
}

function setNewPlayerPosition(data) {
    var newPos = [];
    var willWork = false;
    var possibleX, possibleY;
    var i = 0;
    while(!willWork && i < (29*14)) {
        possibleX = Math.floor( (Math.random() * GAME_WIDTH) + 1);
        possibleY = Math.floor( (Math.random() * GAME_HEIGHT) + 1);
        var willWork = true;
        data.players.forEach( function(entry) {
            entry.positions.forEach( function(pos) {
                if( pos[0] == possibleX && pos[1] == possibleY ) willWork = false;
            });
        });
	++i;
    }
    newPos[0] = possibleX;
    newPos[1] = possibleY;
    return newPos;
}

http.listen(3000, function(){
  console.log('listening on *:3000');
});