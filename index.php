<!doctype html>
<html lang="en">
 	<head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/alchemyjs/0.4.2/alchemy.min.css"/>
		  <meta charset="utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		  <script src="https://timmywil.github.io/jquery.panzoom/test/libs/jquery.js"></script>
    	  <script src="https://timmywil.github.io/jquery.panzoom/dist/jquery.panzoom.js"></script>
    	  <script src="https://timmywil.github.io/jquery.panzoom/test/libs/jquery.mousewheel.js"></script>
		    <style>
		    html{
		    	height:100%;
		    }
		    body{ 
		    	font-family: helvetica;
		    	min-height: 100%;
		    	background: #f4f5f7;
		    }
		  	a {
		  		color: blue;
		  	}
		  	.column
		  	{
		  		
		  		float:left;
		  		height: 93.5vh;
		  	}
		  	#left
		  	{
          margin-top: 0px;
		  		text-align:center;
		  		width:27.5%;
		  	}
		  	#right
		  	{
		  		background: #f4f5f7;
		  		border-left:2px solid black;
		  		width:72.5%;
		  	}
		  	.navbar{
		  		margin-bottom: 0px;
		  	}
		  	h2
		  	{
		  		margin-top: 1vh;
		  	}
        h4
        {
          margin-top: 0.5vh;
          margin-bottom: 4vh;
        }
		  	#contact
		  	{
		  		margin-top: 5vh;
		  		margin-left: 27.5vw; 
		  	}
		  	.buttons
		  	{
		  		text-align:center;
		  	}		  	
		    </style>
		   <title>Hello, world!</title>
  	</head>
  <body >
  	<nav class="navbar navbar-inverse">
  		<div class="container-fluid">
    		<div class="navbar-header">
      			<a style="color: red;" class="navbar-brand" href="#">YouTube Web</a>
    		</div>
       		<ul class="nav navbar-nav">
      			<li class="active"><a href="./about.html">About</a></li>
    		</ul>
  		</div>
	</nav>	
	 
	<div class="column" id = "left" style="background: #e1e5ed;">
		<h2 id="userID" style="padding-left:1vw;">----</h2>
		<iframe id="video" style= "width: 100%; height:40%; margin-bottom: 1.5vh;"
			src="https://www.youtube.com/embed/"
			allowfullscreen="allowfullscreen">
		</iframe>
    <h4 id="subC" style="padding-left:1vw;">Subscribers: N/A</h4>
    <h4 id="viewC" style="padding-left:1vw;">Views: N/A</h4>
    <h4 id="vidC" style="padding-left:1vw;">Videos: N/A</h4>
    <h4 id="comC" style="padding-left:1vw;">Comments: N/A</h4>
	</div>
	<div class = "column" id = "right">
      <div class="alchemy" id="alchemy"></div>
      <script src="d3/d3.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/alchemyjs/0.4.2/scripts/vendor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/alchemyjs/0.4.2/alchemy.min.js"></script>  
        
        <script type="text/javascript">
            var config = {
                    dataSource: './graph.json',
                    directedEdges: true,
                    search: true
                };
    		
            alchemy.begin({dataSource: "./graph.json"});

            $(document).ready( function() {
                setTimeout(function afterTwoSeconds() {
                  $('.node').on('click', function() {
                    var node_and_id = this.id;
                    var only_id = this.id.substring(5, this.id.length);
                    search(only_id);
                  });
                }, 3000)
            });
        </script>
      <script>
        function onClientLoad() {
                gapi.client.load('youtube', 'v3', onYouTubeApiLoad);
            }
            // Called automatically when YouTube API interface is loaded (see line 9).
            function onYouTubeApiLoad() {
                gapi.client.setApiKey('AIzaSyDp7y3OsCrUT1sXkCHWqzPAPLnL1i7EqH0');
            }
 
            // Called when the search button is clicked in the html code
            function search(channel) {
                var request = gapi.client.youtube.search.list({
                    order: 'date',
                    part: 'snippet',
                    channelId: channel,
                    maxResults: 1,
                });
                var request2 = gapi.client.youtube.channels.list({
                    part: 'snippet,statistics',
                    id: channel
                })
                // Send the request to the API server, call the onSearchResponse function when the data is returned
                request.execute(onSearchResponse);
                request2.execute(onSearchStats);
            }
            // Triggered by this line: request.execute(onSearchResponse);
            function onSearchResponse(response) {
                document.getElementById('video').setAttribute("src","https://www.youtube.com/embed/"+response['items'][0]['id']['videoId'])
                document.getElementById('userID').innerHTML=response['items'][0]['snippet']['channelTitle']
            }
            function onSearchStats(stats) {           
                const numberWithCommas = (x) => {
                  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } 
                document.getElementById('subC').innerHTML="Subscribers: "+numberWithCommas(stats['items'][0]['statistics']['subscriberCount'])
                document.getElementById('viewC').innerHTML="Views: "+numberWithCommas(stats['items'][0]['statistics']['viewCount'])
                document.getElementById('vidC').innerHTML="Videos: "+numberWithCommas(stats['items'][0]['statistics']['videoCount'])
                document.getElementById('comC').innerHTML="Comments: "+numberWithCommas(stats['items'][0]['statistics']['commentCount'])
            }
      </script>
      <script src="https://apis.google.com/js/client.js?onload=onClientLoad" type="text/javascript"></script>         
	</div>
  </body>
</html>