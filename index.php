<?php session_start(); ?>
<?php require_once 'protected/config.php'; ?>
<?php require_once USER_MANAGER; ?>

<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beadandó</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/design.css">
    <script src="jquery-3.5.0.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#sel_brand").change(function(){
                var brdid = $(this).val();

                $.ajax({
                    url: 'public/getModels.php',
                    type: 'post',
                    data: {brand:brdid},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#sel_model").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['model_name'];
                            
                            $("#sel_model").append("<option value='"+id+"'>"+name+"</option>");

                        }
                    }
                });
            });

        });
    </script>

</head>
<body>
    <div class="container-fluid">
        <header><?php include_once PROTECTED_DIR.'header.php';?></header>
        <main><?php require_once PROTECTED_DIR.'routing.php'?></main>
        <footer><?php include_once PROTECTED_DIR.'footer.php'?></footer>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>