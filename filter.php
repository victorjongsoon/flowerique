


<?php

include_once("mysql_conn.php"); 

$qry ="SELECT DISTINCT * from productspec ps Inner Join specification s on ps.SpecId =s.SpecId where s.SpecName='Occasion' ";


$result2=$conn->query($qry);




// $MainContent.='<div class="col-12" id="slider"></div>';


$MainContent.='<div id="myDropdown" class="col-4 border rounded" style="display:None;">';
$MainContent.= '<form action="" method="get">
<div class="form-group">
<h3 align="center">Filtered Search</h3>
<label for="range">Price Range</label>
<div class="row justify-content-center">
<input type="number" class="form-control col-lg-5 col-sm-11" id="minPrice" placeholder="Min Price" min=0>
<div class="input-group-addon col-1 d-flex justify-content-center"> - </div>

<input type="number" class="form-control col-lg-5 col-sm-11" id="maxPrice" placeholder="Max Price" min=0>
</div>
</div>
<div class="form-group">
<label for="exampleFormControlSelect1">Ocassion: </label>
<select class="form-control col-12" id="exampleFormControlSelect1">';
while ($row2=$result2->fetch_array()) {
  
 $MainContent.="<option> $row2[SpecVal] </option>" ;
 
}
$MainContent.='</select>';

// while ($row=$result->fetch_array()) {

// $MainContent.='<div class="form-check">
// <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
// <label class="form-check-label" for="defaultCheck1">
//   Default checkbox
// </label>
// </div>';


$MainContent.='</div>';
$MainContent.='<div class="float-right mt-25">';
$MainContent.='<input type="submit" class="button" value="Search">';
$MainContent.='</div>';
$MainContent.= '</form >';

$MainContent.='</div>';

 

?>


 <!-- <a class="dropdown-item" href="#">Action</a>
  <a class="dropdown-item" href="#">Another action</a>
  <a class="dropdown-item" href="#">Something e lse here</a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Separated link</a> -->