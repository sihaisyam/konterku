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
        
        <div id="message">
        </div>
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
                    <input type="date" class="form-control" id="date_sell">
                </div>
                <div class="col-md-6">
                    <label for="kasir" class="form-label">Kasir</label>
                    <input type="text" class="form-control" id="kasir" value="<?php echo $_SESSION['user']['fullname']; ?>">
                </div>
                <div class="col-12" id="target_area">
                    <div class="row g-1 p-1" >
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Kode Barang</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Nama Barang</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Harga</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">QTY</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Sub Total</label>
                        </div>
                        <div class="col-md-2">
                            <label for="deleteBrg" class="form-label">Action</label>
                        </div>
                    </div>
                    <div class="row g-1 p-1" data-area="area_50">
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="kd_brg[]" id="kd_brg">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="nama_brg[]" id="nama_brg">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="harga_jual[]" id="harga_jual">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="qty[]" id="qty">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="sub_total[]" id="sub_total" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="delete_colom" class="btn btn-danger" >Delete</button>
                            <button type="button" id="add_colom" class="btn btn-secondary">Add</button>
                        </div>
                    </div>
                </div>
                <div class="row g-1">
                    <div class="col-md-5 text-end align-items-center">
                        <label for="total" class="form-label">GRAND TOTAL</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="total" readonly>
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

            handleBtnDeleteColom();
            handleBtnAddColom();
            handleHitung();

            $('#sample_form').on('submit', function(event){
                event.preventDefault();

                const details = [];
                $('[data-area]').each(function() {
                    detail = {
                        "trxid": $('#notrx').val(),
                        "kd_brg": $(this).find('input#kd_brg').val(),
                        "nama_barang":$(this).find('input#nama_brg').val(),
                        "harga_jual": $(this).find('input#harga_jual').val(),
                        "qty": $(this).find('input#qty').val(),
                        "sub_total":$(this).find('input#sub_total').val()
                    };
                    details.push(detail);
                });

                
                
                var formData = {
                    "trxid": $('#notrx').val(),
                    "date_sell": $('#date_sell').val(),
                    "nama_customer": $('#nama_customer').val(),
                    "kasir": $('#nama_customer').val(),
                    "grand_total" : $('#total').val(),
                    "details" : details
                }
                console.log(JSON.stringify(formData));

                $.ajax({
                    url:"http://localhost:81/konterku/api/penjualan/create.php",
                    method:"POST",
                    data: JSON.stringify(formData),
                    success:function(data){
                        $('#action_button').attr('disabled', false);
                        window.location.href = 'http://localhost:81/konterku/views/penjualan/';
                    },
                    error: function(err) {
                        console.log(err);   
                        $('#message').html('<div class="alert alert-danger">'+err.responseJSON+'</div>');  
                    }
                });
            });

            function handleBtnAddColom(){
                var target_area = $("#target_area");
                $("button#add_colom").off("click").on("click", function(){
                    var _this = $(this),
                    currentArea = _this.parent().parent(),
                    cloningan = currentArea.clone();

                    target_area.append(cloningan);
                    setTimeout(() => {
                        handleBtnAddColom();
                        handleHitung();
                        handleBtnDeleteColom();
                    }, 500);
                });
            }
            
            function handleBtnDeleteColom(){
                $("button#delete_colom").off("click").on("click", function(){
                    var el_count = $('[data-area]').length;
                    //alert(el_count);
                    if(el_count < 2){
                        return false;
                    }

                    var _this = $(this),
                    currentArea = _this.parent().parent();

                    currentArea.remove();
                    gotoView();
                });
            }

            function handleHitung(){
                $('input#qty').off("input").on("input", function(){
                    var _this = $(this),
                    currentArea = _this.parent().parent();
                    harga = currentArea.find('input[name="harga_jual[]"]').val();
                    qty = currentArea.find('input[name="qty[]"]').val();
                    // console.log(bi+"*"+qty);
                    total = harga*qty;

                    currentArea.find('input[name="sub_total[]"]').val(total);
                    hitungTotal();
                });   
            }

            function hitungTotal(){
                var total = 0;
                $('[data-area="area_50"]').each(function(){
                    var _this = $(this);
                    subtot =  _this.find("input[name='sub_total[]']").val();
                    total += parseFloat(subtot);
                });
                $('#total').val(total);
                // console.log(total);

            }

            function gotoView(){
                var el = $('[data-area="area_50"]').find(".row:last-child")[0];
                el.scrollIntoView();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>