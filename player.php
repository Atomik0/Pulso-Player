<?php require("config.php"); ?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel='stylesheet' href='assets/css/bootstrap.css' type='text/css' media='all' />
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Open%20Sans:400&#038;display=swap&#038;ver=1668600823" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open%20Sans:400&#038;display=swap&#038;ver=1668600823" media="print" onload="this.media='all'">
        
        <script type='text/javascript' src='assets/js/jquery.js' id='jquery-core-js'></script>

        <script>
            var $ = jQuery; 
 
            function zajax_send() {  };
            function zajax_complete() {  };
        </script>

        <style type="text/css" id="wp-custom-css">
            body {
                font-family: open sans,Arial,Helvetica,sans-serif;
                font-size:13px;
                font-weight:500;
                color:#ddd;
                line-height:1.8em;
                padding:0;
            }

            .play {
                display:block;
                width:40px;
                float:left;
                margin:16px 0 0 15px;
                z-index:10000;
            }

            .now {
                display:block;
                height:30px;
                margin:15px 0 0 20px;
                font-size:10px;
                text-align:left;
                float:left;
                z-index:10000;
            }

            .player-bottom {
                height: 60px;
                z-index:9999;
                background:#252424;
                position:fixed;
                width:110%;
                margin:0 auto;
                padding:0;
                bottom: 0;
            }

            .nowplay {
                background-color:#ffffff00; 
                display: block;
                float: left;
                margin: 0 auto;
                text-align: center;
                padding: 18px 20px 0px 20px;
                font-size: 20px;
            }

            #play-player {
                background-color: transparent;
                border: 0px;
                color: #ffffff;
                font-size: 28px;
                width: 35px;
                border: none;
                outline: none;
                cursor:pointer;
            }
            
            #play-player:hover {
                color: #ffffff;
            }
            
            .volume {
                float: left;
                margin-top: 10px;
            }
            
            @media(max-width:470px) {
                .volume {
                    display:none;
                }

                .nowplay {
                    font-size: 14px;
                }
            }
            
            .volume div {
                text-align: center;
                margin-bottom: -8px;
            }
                    
            .title-volume {
                color: #ffffff;
                font-size: 11px;
                margin-left: -5px;
            }
            
            .volume-player .rangeValue {
                color: #ffffff;
                font-size:12px;
                margin:0px 5px;
                float:left;
            }
            
            .volume-player .range {
                width: 80px;
                height: 8px;
                -webkit-appearance: none;
                background: #3e3e3e;
                outline: none;
                border-radius: 15px;
                overflow: hidden;
                float:left;
                margin-top: 7px;
                cursor:pointer;
            }

            .volume-player .range::-webkit-slider-thumb {
                -webkit-appearance: none;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: #ffffff;
                cursor: pointer;
                box-shadow: -407px 0 0 400px #ffffff;
            }
        </style>
    </head>

    <body>
        <div class="col-md-12 player-bottom">
            <div class="now">
                <a href="<?php echo $shoutcast_nowplaying; ?>" class="cc_streaminfo" data-type="song" data-username="radiopulso" style="display: inline;font-size: 12px;"><span class="nowplaying"></span></a>
            </div>

            <div class="now">
                <audio controls="" style="display:none;" id="player">
                    <source src="<?php echo $shoutcast_player; ?>" type="audio/mpeg">
                </audio>

                <button class="playpause stopped" id="play-player" title="Escuchar Radio"><i class="fa fa-play" aria-hidden="true"></i></button>
            </div>

            <div class="volume d-none d-md-block">
                <div>
                    <span class="title-volume">Volumen</span>
                </div>

                <div class="volume-player">
                    <span class="rangeValue">-</span>
                    <input class="range" type="range" name="volume" min="0" max="1" step="0.1" value="0.5">
                    <span class="rangeValue">+</span>
                </div>
            </div>

            <div class="play">
                <a style="cursor:pointer" onclick="window.open('<?php echo $shoutcast_live; ?>','<?php echo $site_name; ?>','width=400,height=600')"><img src="<?php echo $site_url; ?>/wp-content/plugins/pulsoplayer/assets/img/lisnter.png" style="width:30px; height:30px;" alt=""></a>
            </div>

            <div class="nowplay">
                <p>AHORA SONANDO</p>
            </div>
        </div>
    </body>

    <script>
        $(document).ready(function () {
            $("#play-player").on('click', function() {
                $(this).toggleClass("stopped playing");
                $('#player').prop("volume", "0.5"); 
				
                if($(this).is('.stopped')) {
                    $(this).html('<i class="fa fa-play"></i>');
                    $("audio")[0].pause();     
                }
				else {
                    $(this).html('<i class="fa fa-pause"></i>');
                    $("audio")[0].play();     
                }
            }).addClass('stopped');
            
            $.get("<?php echo $shoutcast_currentsong; ?>", function(data) {
				if(data.coverart == null || data.coverart == false) {
					$("#art-image").attr("src", "<?php echo $site_url; ?>/wp-content/plugins/pulsoplayer/assets/img/logo-radio.png"); 
				}
				else {
					$("#art-image").attr("src", data.coverart);
				}

				if(data.servername == "") {
					$(".nowplay").html("<p>OFFLINE</p>");  
				}
				if(data.nowplaying == "") {
					$(".nowplaying").text("<?php echo $site_name; ?>");  
				}
				else {
					$(".nowplaying").text(data.nowplaying); 
				}
            });
            
            $('.range').on('change', function() {
                $('#player').prop("volume", this.value);
            });
        });
    </script>
</html>