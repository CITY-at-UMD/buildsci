<html>

<head>
    <script src="./amcharts.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="./amcharts.js" type="text/javascript"></script>
    
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	
    <?php
        require 'VirtualPULSE.php';
        
        $VP = new VirtualPULSE();
        $VP->setModelName("JinAnTestBuilding168");
    ?>
    
    <script>
        $(document).ready(function(){
            $(".resizable").resizable({
                containment: "parent"
            });
            
         //   $("button").click(function() {
          //      $("div").hide().fadeIn("slow");
                
          //  });   
        });
        
    </script>
</head>

<body>
    <div id="panel" class="resizable" style="display: block; border: 1px red solid; height: 800px; width: 1200px;">
        <?php
            $VP->displayMonthlyData(3);
        ?>
    </div>

    <button onClick="refresh()"> refresh </button>
    
    <script>
        function refresh() {
            var panel = document.getElementById("panel");
            panel.innerHTML= '<?php echo "hello"; ?>';
        }
    </script>
    
</body>

</html>