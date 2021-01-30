<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Flowerique</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- JQuery Library -->
        <link href="nouislider.css" rel="stylesheet">
        <script src="nouislider.js"></script>
        <script src= js/jquery-3.3.1.min.js></script>
        <!-- Latest compiled JavaScript -->
        <script src= js/bootstrap.min.js></script>
        <!-- Site specific Cascading Stylesheet -->
        <!-- Included after bootstrap CSS to avoid being overwritten -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container">
            <!-- 1st Row -->
            <div class="row">
                <div class="col-sm-12">
                    <a href="index.php">
                        <img src="Images/flowerique.jpg" alt="Logo" class="img-fluid"/>
                    </a>
                </div>
                
            </div>
            <!-- 2nd Row -->
            <div class="row">
                <div class="col-sm-12">
                    <?php include("navbar.php"); ?>
                </div>
            </div>
            
            <!-- 3rd Row -->
            <div class="row" class="col-sm-12" style="padding:15px">
                <?php echo $MainContent; ?>
            </div>
            <!-- 4th Row -->
            <div class="row">
                <div class="col-sm-12" style="text-align: right;">   
                    <hr/>
                    Do you need help? Please email to:
                    <a href="flowerique@np.edu.sg">flowerique@np.edu.sg</a>
                    <p style="font-size:12px">&copy;Copyright by Flowerique Group</p>

                </div>
            </div>
        </div>

        
        
    </body>
</html>