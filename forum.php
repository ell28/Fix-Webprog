<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="./images/favicon.png" type="image/png" sizes="16x16">
  <title>forum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/forum.css">
</head>

<?php
include 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
  if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
  }
  $name = $fetch['name'];
  $image = "uploaded_img/" . $fetch['image'] . "";
}
?>

<body class="forumBody">
  <?php if (isset($_SESSION['user_id'])) :  ?>
    <!-- HEADER -->
    <header>
      <div class="logo">
        <a href=index.php>
          <img src="assets/logo-transparent.png">
        </a>
      </div>
      <!-- PROFILE PICTURE -->
      <div class="profile">
        <a href="profile.php" class="profile-picture">
          <?php
          if (isset($user_id)) {
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
            if (mysqli_num_rows($select) > 0) {
              $fetch = mysqli_fetch_assoc($select);
              if (array_key_exists('image', $fetch) && $fetch['image'] != '') {
                echo '<img src="uploaded_img/' . $fetch['image'] . '">';
              } else {
                echo '<img src="assets/account/default-avatar.png">';
              }
            } else {
              echo '<img src="assets/account/default-avatar.png">';
            }
          } else {
            echo '<img src="assets/account/default-avatar.png">';
          }
          ?>
        </a>
      </div>

      <!-- NAV BUTTON -->
      <nav>
        <ul>
        <?php if (isset($user_id)) {
                            $role_type = mysqli_query($conn, "SELECT role_type FROM user_form WHERE id = '$user_id'");
                        if (mysqli_num_rows($role_type) > 0) {
                            $role = mysqli_fetch_assoc($role_type);
                            if ($role['role_type'] == 'admin') {
                                    echo '<li><a href="adminpage.php">ADMIN</a></li>';
                                }
                            }
                        }

        ?>
          <li><a href="explore.php" class="active">EXPLORE</a></li>
          <li><a href="forum.php">FORUM</a></li>
          <li><a href="aboutus.php">ABOUT US</a></li>
        </ul>
      </nav>
    </header>


    <!-- Comment -->
    <div class="container">
      <div class="panel panel-default" style="margin-top:50px">
        <div class="panel-body">
          <h3>Community forum</h3>
          <hr>
          <form name="frm" method="post">
            <input type="hidden" id="commentid" name="Pcommentid" value="0">
            <div class="form-group">
              <input type="hidden" class="form-control" name="name" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
              <textarea class="form-control" placeholder="Write your message:" rows="5" name="msg" required></textarea>
            </div>
            <input type="button" id="butsave" name="save" class="btn btn-primary" value="Send">
          </form>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Recent messages</h4>
          <table class="table" id="MyTable" style="border:0px;border-radius:10px">
            <tbody id="record">

            </tbody>
          </table>
        </div>
      </div>

    </div>

    <!-- Reply -->
    <div id="ReplyModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reply Message</h4>
          </div>

          <div class="modal-body">
            <form name="frm1" method="post">
              <input type="hidden" id="commentid" name="Rcommentid">
              <div class="form-group">

                <input type="hidden" class="form-control" name="Rname" value="<?php echo $name; ?>">
              </div>
              <div class="form-group">
                <textarea class="form-control" placeholder="Write your reply:" rows="5" name="Rmsg" required></textarea>
              </div>
              <input type="button" id="btnreply" name="btnreply" class="btn btn-primary" value="Reply">
            </form>
          </div>
        </div>

      </div>
    </div>

  <?php else : header("Location: login.php") ?>
  <?php endif; ?>
  <script>
    var myVar = setInterval(LoadData, 2000);

    http_request = new XMLHttpRequest();

    function LoadData() {
      $.ajax({
        url: 'view.php',
        type: "POST",
        dataType: 'json',
        success: function(data) {
          $('#MyTable tbody').empty();
          for (var i = 0; i < data.length; i++) {
            var commentId = data[i].id;
            if (data[i].parent_comment == 0) {
              var row = $('<tr><td><b>' + data[i].student + ' :<i> ' + data[i].date + ':</i></b></br><p style="padding-left:80px">' + data[i].post + '</br><a data-toggle="modal" data-id="' + commentId + '" title="Add this item" class="open-ReplyModal" href="#ReplyModal">Reply</a>' + '</p></td></tr>');
              $('#record').append(row);
              for (var r = 0;
                (r < data.length); r++) {
                if (data[r].parent_comment == commentId) {
                  var comments = $('<tr><td style="padding-left:80px"><b>' + data[r].student + ' :<i> ' + data[r].date + ':</i></b></br><p style="padding-left:40px">' + data[r].post + '</p></td></tr>');
                  $('#record').append(comments);
                }
              }
            }
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error: ' + textStatus + ' - ' + errorThrown);
        }
      });
    }



    $(document).on("click", ".open-ReplyModal", function() {
      var commentid = $(this).data('id');
      $(".modal-body #commentid").val(commentid);
    });



    //Post data to the server
    $(document).ready(function() {
      $('#butsave').on('click', function() {
        $("#butsave").attr("disabled", "disabled");
        var id = document.forms["frm"]["Pcommentid"].value;
        var name = document.forms["frm"]["name"].value;
        var msg = document.forms["frm"]["msg"].value;
        if (name != "" && msg != "") {
          $.ajax({
            url: "save.php",
            type: "POST",
            data: {
              id: id,
              name: name,
              msg: msg,
            },
            cache: false,
            success: function(dataResult) {
              var dataResult = JSON.parse(dataResult);
              if (dataResult.statusCode == 200) {
                $("#butsave").removeAttr("disabled");
                document.forms["frm"]["Pcommentid"].value = "";
                document.forms["frm"]["name"].value = "";
                document.forms["frm"]["msg"].value = "";
                LoadData();
              } else if (dataResult.statusCode == 201) {
                alert("Error occured !");
              }

            }
          });
        } else {
          alert('Please fill all the field !');
        }
      });
    });

    //Reply comment
    $(document).ready(function() {
      $('#btnreply').on('click', function() {
        $("#btnreply").attr("disabled", "disabled");
        var id = document.forms["frm1"]["Rcommentid"].value;
        var name = document.forms["frm1"]["Rname"].value;
        var msg = document.forms["frm1"]["Rmsg"].value;
        if (name != "" && msg != "") {
          $.ajax({
            url: "save.php",
            type: "POST",
            data: {
              id: id,
              name: name,
              msg: msg,
            },
            cache: false,
            success: function(dataResult) {
              var dataResult = JSON.parse(dataResult);
              if (dataResult.statusCode == 200) {
                $("#btnreply").removeAttr("disabled");
                document.forms["frm1"]["Rcommentid"].value = "";
                document.forms["frm1"]["Rname"].value = "";
                document.forms["frm1"]["Rmsg"].value = "";
                LoadData();
                $("#ReplyModal").modal("hide");
              } else if (dataResult.statusCode == 201) {
                alert("Error occured !");
              }

            }
          });
        } else {
          alert('Please fill all the field !');
        }
      });
    });
  </script>
</body>

</html>