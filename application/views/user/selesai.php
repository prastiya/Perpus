<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-30 mt-2 pt-5 rounded">
        <div class="card mb-2" style="width: 510px; ">
          <div class="row no-gutters">
            <div class="col-md-11 ">
              <div class="card-body ml-5 pt-2">
                <center><p class="card-header">~ Sie Perpus ~</p>
                <h5 class="card-title"></h5>
                <p class="card-text">Terima kasih <?= $user['name']; ?> <i class="far fa-smile-beam"></i></p>
                <p class="card-text">Kamu telah meminjam buku</p>
                <p class="card-text">Ingat! Jangan lupa mengembalikan bukunya ya..!</p>
              </div>
            </div>
          </div>
        </div>
      <button type="button" class="btn btn-success" >
          <a class="text-white" href="<?= base_url('user/buku'); ?> ">Kembali <i class="fas fa-backward"></i></a></button>
      </div>
    </center>
    </div>