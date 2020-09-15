<?php
//create connection to database
$servername="localhost";
$username="root";
$password="";
$database="dbprac";
$insert="False";

//create a connection object
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
  echo "connection failed";
}
else{
  if(isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $sql="delete from note where slno='$sno'";
    $result=mysqli_query($conn,$sql);
  }
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoEdit'])){
    //update
    $sno=$_POST["snoEdit"];
    $title=$_POST["TitleEdit"];
  $desc=$_POST["descriptionEdit"];

  $sql="UPDATE note SET title='$title',description='$desc' where slno='$sno'";
  $result=mysqli_query($conn,$sql);
  }
  else{
	$title=$_POST["Title"];
	$desc=$_POST["description"];
	//insert
	$sql="INSERT INTO note(title,description)VALUES('$title','$desc')";
	$result=mysqli_query($conn,$sql);
  
if($result){
	$insert="True";
}
else{
	echo"not INSERTED created".mysqli_error($conn);
}
}
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

  
    <title>I_NOTE</title>

    
  </head>
  <body>


<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditModal">
  Launch demo modal
</button>-->

<!-- Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditModalLabel">edit note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--form-->
        <form action="/inote/index.php" method="POST">
        <input type="hidden" name="snoEdit" id="snoEdit">
  <div class="form-group">
    <label for="TitleEdit">Note Title</label>
    <input type="text" class="form-control" id="TitleEdit" name="TitleEdit" aria-describedby="emailHelp">
    
  </div>
  <div class="form-group">
    <label for="descriptionEdit">Note Description</label>
    <textarea class="form-control" id="descriptionEdit"name="descriptionEdit" col="30" row="30"></textarea>
  </div>
  
  <button type="submit" class="btn btn-primary">update</button>
</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">iNOTES</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">about</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="#">contact us</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">SEARCH</button>
    </form>
  </div>
</nav>
<?php
if($insert=="True"){
  echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>success</strong> Your record has been inserted successfully.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
$insert="False";
  
}
?>
<div class="container my-5">
<h3>Add Your Note</h3>
<form action="/inote/index.php" method="POST">
  <div class="form-group">
    <label for="Title">Note Title</label>
    <input type="text" class="form-control" id="Title" name="Title" aria-describedby="emailHelp">
    
  </div>
  <div class="form-group">
    <label for="description">Note Description</label>
    <textarea class="form-control" id="description"name="description" col="30" row="30"></textarea>
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
<div class="container my-5">

<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">slno</th>
      <th scope="col">title</th>
      <th scope="col">description</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
  <?php
$sql="select * from note";
$result=mysqli_query($conn,$sql);
$sno=0;
while($row=mysqli_fetch_assoc($result)){
	$sno=$sno+1;
  $serial=$row['slno'];
	echo"<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['title']."</td>
      <td>".$row['description']."</td>
      <td><button type='button' class='edit btn btn-primary' id=".$serial.">edit</button>&nbsp&nbsp&nbsp
      <button type='button' class='delete btn btn-primary' id=d".$serial.">delete</button></td>
    </tr>";
    	
}

?>
  </tbody>
</table>
</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>

    <script>
    edits=document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("edit");
        tr=e.target.parentNode.parentNode
        title=tr.getElementsByTagName("td")[0].innerText;
        description=tr.getElementsByTagName("td")[1].innerText;
        console.log(title,description);
        snoEdit.value=e.target.id;
        descriptionEdit.value=description;
        TitleEdit.value=title;
        $('#EditModal').modal('toggle');
      })
    })

    deletes=document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("deletes");
        sno=e.target.id.substr(1,);
        
        if(confirm("press a button")){
          window.location=`/inote/index.php?delete=${sno}`;
        }
      })
    })
    </script>
  </body>
</html>
