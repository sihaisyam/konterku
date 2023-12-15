<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  </head>
  <body>
    <div class="container">
        <div id="message">
        </div>
        <div class="container px-4">
            <form class="row g-1" id="sample_form">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="col-md-6">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" id="action_button">Sign In</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                
                var formData = {
                'email' : $('#email').val(),
                'pass' : $('#pass').val()
                }
                $.ajax({
                    url:"http://localhost:81/konterku/api/auth/login.php",
                    method:"POST",
                    data: JSON.stringify(formData),
                    success:function(data){
                        $('#action_button').attr('disabled', false);
                        window.location.href = 'http://localhost:81/konterku/views/dashboard/';

                    },
                    error: function(err) {                        
                        console.log(err);   
                        $('#message').html('<div class="alert alert-danger">'+err.responseJSON+'</div>');   
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>