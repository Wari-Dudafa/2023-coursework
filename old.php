<!DOCTYPE html>
<html lang="en">
<head>
    <title>Branch Launch Page</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
</head>
<body>       
    <div class="mainloader">
        <center>
            <h1>Welcome to Branch!</h1>
            <h2>We are implementing the final features!</h2>
            <h2 id="demo"></h2>
            <div class="loader">
                <!--Clark, no robes mi código.-->
            </div>
        </center>

        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("Mar 25, 2023 00:00:00").getTime();
            
            // Update the count down every 1 second
            var x = setInterval(function() {
            
                // Get today's date and time
                var now = new Date().getTime();
                
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Output the result in an element with id="demo"
                document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";
                
                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "Any time now...";
                }
            }, 1000);
        </script>

    </div>

</body>
</html>