<?php $MainContent = "<div style='width:100%; margin:auto;'>";
        // Display Page Header - 
        // Category's name is read from query string passed from previous page.
        $MainContent .= "<div class='row' style='padding:5px'>";
        $MainContent .= "<div class='col-12'>";
        $MainContent .= "<span class='page-title'>Filtered Results for $_GET[catName]</span>";
        $MainContent.='<div class="btn-group float-right">';
        $MainContent.='<form method="get" action="clearFilter.php">';
        $MainContent.='<input type="submit" class="button" value="Clear Filter">';
        $MainContent.="<input type='hidden' name='catName' class='button' value='$_GET[catName]'>";
        $MainContent.="<input type='hidden' name='cid' class='button' value='$_GET[cid]'>";
      
        $MainContent.='</form>';
        $MainContent.='</div>';

        $MainContent .= "<hr style='height:5px;color:gray;'/>";

        $MainContent .= "</div>";

        $MainContent .= "</div>";
        

        include('productListTemplate.php');
        $MainContent.="</div>";
        $MainContent .= "</div>"; // End of container

?>