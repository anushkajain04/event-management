<script>
        function simulateHostLogin() {
            document.getElementById("readymsg").style.display = "none";
            document.getElementById("signin").style.display = "none";
            document.getElementById("hostEvent").style.display = "block";
        }

        document.getElementById("signin").onclick = function () {
            window.location.href = "jnu_login.html"; 
        };

        document.getElementById("hostEvent").onclick = function () {
            window.location.href = "host.html"; // Replace with your host event page
            
        };
    </script>