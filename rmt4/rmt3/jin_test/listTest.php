<html>

<head> </head>

<script> 
    function printSomething(number) {
        document.getElementById('panel').innerHTML='Hello Number '+number;
    }
</script>

<body>
    <h1> Test The List </h1>
    <div id="panel" style="width:400px; height:800px; border:solid;">
        <h2> what is going on? <h2> 
    
        <ul style="list-style-type: none;">
            
            
            <?php 
                for($i=0; $i<10; $i++) {
                    echo '<li onclick="printSomething('.$i.')" > <a href="#"> '.$i.' </a> </li>';
                    //'<li onclick="printSomething('.$i.') >'.$i.' </li>';
                }
            ?>
        </ul>
    </div>
    
</body>

</html>