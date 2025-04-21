<?php
session_start();
include "core/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
$mod = new Model();
$ctr = new Controller();
$ctr->customerDelete();
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title text-white">Send Bulk SMS</h3>
          </div>
          <form action="" method="post" class="form-horizontal">
            <div class="card-body">
              <div class="form-group">
                <label class="control-label">Title :</label>
                <div class="controls">
                  <input type="text" class="form-control" name="title"  Required />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Message Body:</label>
                <div class="controls">
                  <textarea name="message" id="" class="form-control" cols="30" rows="10"></textarea>
                </div>
              </div>
              <div class="form-actions float-right">
                <input type="submit" name="send_sms" class="btn btn-success" value="Send SMS">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-8" style="height:90vh; overflow: scroll">
        <div class="card">
          <div class="card-header">
            <h3 class="">Previous Messages</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Title</th>
                  <th>Message</th>
                  <th>Date</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $id = 0;
                $user = new Model();
                $select = $mod->showBulkSMS();
                while ($row = mysqli_fetch_array($select)) { ?>
                  <tr>
                    <td><?php echo ++$id ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['message'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><a href="bulk_sms.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a></td>
                  </tr>
                <?php }
                ?>


              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $ctr->addBulkSMS();
?>
   


<!--end-main-container-part-->
<?php
include "includes/footer.php";
?>