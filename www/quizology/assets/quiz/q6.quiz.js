I. Tile Sprite
    bg1 = game.add. 1._____________(2. ____, 3.____, 4. _______, 5. ________, 6. _______); // give the function used to make a tile sprite and its respective parameters.

var imageHeight;
basicGame.prototype = {
    preload: function(){
        game.load.image("bundok1","img/mountains-back.png");
        game.load.image("bundok2","img/mountains-mid1.png");
        game.load.image("bundok3","img/mountains-mid2.png");
    },
    create: function(){
        game.stage.7._____________ = "#ddd"; // change the game background color to light gray or #ddd;

        imageHeight = 8.___________________________________; // get the cached image height of bundok1;
        bg1 = game.add.tileSprite(0,
            game.height - imageHeight,
            bounds,
            imageHeight,
            'bundok1');

        imageHeight = 9.___________________________________; // get the cached image height of bundok2;
        bg2 = game.add.tileSprite(0,
            game.height - imageHeight,
            bounds,
            imageHeight,
            'bundok2');

        imageHeight = 10.___________________________________; // get the cached image height of bundok3;
        bg3 = game.add.tileSprite(0,
            game.height - imageHeight,
            bounds,
            imageHeight,
            'bundok3');
    },
    update: function(){
        bg1.11. _____________.x -= 1; //function to animate or move the tiles
        bg2.12. _____________.x -= 0.6;//function to animate or move the tiles
        bg3.13. _____________.x -= 0.1;//function to animate or move the tiles
    }
};

game.state.add("play",basicGame,true);