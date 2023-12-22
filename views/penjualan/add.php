<<?php
session_start();
if (!isset($_SESSION['user'])) {
    return header('Location: http://localhost:81/konterku/views/login/' );
}
?>
!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  </head>
  <body>
    <div class="container">
        <div class="container px-4">
            <form class="row g-1" id="sample_form">
                <div class="col-md-6">
                    <label for="notrx" class="form-label">NOTRX</label>
                    <input type="text" class="form-control" id="notrx">
                </div>
                <div class="col-md-6">
                    <label for="nama_customer" class="form-label">Customer</label>
                    <input type="text" class="form-control" id="nama_customer" placeholder="John Doe">
                </div>
                <div class="col-md-6">
                    <label for="date_cell" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="date_cell">
                </div>
                <div class="col-md-6">
                    <label for="kasir" class="form-label">Kasir</label>
                    <input type="text" class="form-control" id="kasir" value="<?php echo $_SESSION['user']['fullname']; ?>">
                </div>
                <div id="target_area">
                    <div class="row g-1" >
                        <div class="col-2">
                            <label for="kasir" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" name="jumlah[]" id="jumlah">
                        </div>
                        <div class="col-2">
                            <label for="kasir" class="form-label">Harga</label>
                            <input type="text" class="form-control" name="jumlah[]" id="jumlah">
                        </div>
                        <div class="col-2">
                            <label for="kasir" class="form-label">QTY</label>
                            <input type="text" class="form-control" name="jumlah[]" id="jumlah">
                        </div>
                        <div class="col-2">
                            <label for="kasir" class="form-label">Sub Total</label>
                            <input type="text" class="form-control" name="jumlah[]" id="jumlah">
                        </div>
                        <div class="col-2">
                            <label for="deleteBrg" class="form-label">Action</label><br>
                            <button onclick="" class="btn btn-danger" >Delete</button>
                            <button onclick="" class="btn btn-secondary" id="deleteBrg">Add</button>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" id="action_button">Save</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                
                // var formData = {
                // 'fullname' : $('#fullname').val(),
                // 'email' : $('#email').val(),
                // 'pass' : $('#pass').val(),
                // 'roles' : $('#roles').val()
                // }
                // $.ajax({
                //     url:"http://localhost:81/konterku/api/auth/register.php",
                //     method:"POST",
                //     data: JSON.stringify(formData),
                //     success:function(data){
                //         $('#action_button').attr('disabled', false);
                //         $('#message').html('<div class="alert alert-success">'+data.message+'</div>');
                //     },
                //     error: function(err) {
                //         console.log(err);   
                //     }
                // });
            });

            function handleHitung(){
                $('input#jumlah').off("input").on("input", function(){
                    var _this = $(this),
                    currentArea = _this.parent().parent().parent();
                    bi = currentArea.find('input[name="biaya_iuran[]"]').val();
                    qty = currentArea.find('input[name="jumlah[]"]').val();
                    // console.log(bi+"*"+qty);
                    total = bi*qty;

                    currentArea.find('input[name="total[]"]').val(total);
                    hitungTotal();
                });   
            }

            function hitungTotal(){
                var total = 0;
                $('[data-area="area_50"]').each(function(){
                    var _this = $(this);
                    subtot =  _this.find("input[name='total[]']").val();
                    total += parseFloat(subtot);
                });
                $('#grand_total').val(total);
                // console.log(total);

            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>