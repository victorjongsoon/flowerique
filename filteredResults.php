<?php 
        $MainContent = "<div style='width:100%; margin:auto;'>";
        // Display Page Header - 
        // Category's name is read from query string passed from previous page.
        $MainContent .= "<div class='row' style='padding:5px'>";
        $MainContent .= "<div class='col-12'>";
        if(isset($_GET['catName'])){

                $MainContent .= "<span class='page-title'>Filtered Results for $_GET[catName]</span>";
        }
        else{
                $MainContent .= "<span class='page-title'>Filtered Search Result</span>";
        }
        $MainContent.='<div class="btn-group float-right">';
        $MainContent.='<form method="get" action="clearFilter.php">';
        $MainContent.='<input type="submit" class="button" value="Clear Filter">';
        if(isset($_GET['catName'])){
                $MainContent.="<input type='hidden' name='catName' class='button' value='$_GET[catName]'>";
                $MainContent.="<input type='hidden' name='cid' class='button' value='$_GET[cid]'>";
        }
        else{
                $MainContent.="<input type='hidden' name='keywords' class='button' value='$_GET[keywords]'>";
        }
       
      
        $MainContent.='</form>';
        $MainContent.='</div>';
        $MainContent .= "<div class='col--12'>";

        $MainContent .= "<div class='row'>";

        if($_GET["minPrice"]==""){
                $minPrice=0;
        }
        else{
                $minPrice=$_GET["minPrice"];
        }
        if($_GET["maxPrice"]==""){
                $maxPrice=9999;
        }
        else{
                $maxPrice=$_GET["maxPrice"];
        }
        if($_GET["occasion"]==""){
                $occasion="Any occasions";
        }
        else{
                $occasion=$_GET["occasion"];
        }
      
        
        $MainContent .= "<h5><div class='badge badge-pill badge-secondary mr-25'> > $ $minPrice</div></h5>";
        $MainContent .= "<h5><div class='badge badge-pill badge-secondary mr-25' > < $ $maxPrice</div></h5>";
        $MainContent .= "<h5><div class='badge badge-pill badge-secondary'> Occasion: $occasion</div></h5>";
        if(isset($_GET["valid"])){
                $showAvai="Only Available Items";
                $MainContent .= "<h5><div class='badge badge-pill badge-secondary'> $showAvai</div></h5>";
        }
        $MainContent .= "</div>";



        $MainContent .= "<hr style='height:5px;color:gray;'/>";


        if($noResult==FALSE){
                include_once('productListTemplate.php');

        }
        else{
                
                $MainContent.='<div class="col-8">';
                $filterButton='<form method="get" action="clearFilter.php">';
                $MainContent.="<h4 
                style='color:red'>No Record Found</h3>";
                $MainContent.='</div >';

        }
      
        $MainContent.="</div>";       
           

        $MainContent .= "</div>"; // End of container

?>