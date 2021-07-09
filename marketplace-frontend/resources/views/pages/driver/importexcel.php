<?php
if (isset($_POST['detail'])) {
    echo('ok');
    die();
}

?>

<div>
<form method="post" enctype="multipart/form-data">
            <div class="card-body">
            
              <div class="form-group">
                <label for="inputDescription">Details</label>
                <textarea  type="text" name="details"  class="form-control editor" placeholder="Enter details here" rows="4"></textarea>
                <input type="hidden" name="form_type" value="tab-C">
              </div>
            
              <button name="detail" type="submit" class="btn btn-success">Submit</button>  
              
            </div>
            </form>
</div>