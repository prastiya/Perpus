
<?= $this->session->flashdata('pesan'); ?> 
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-30 mt-2 pt-5 rounded">
        <?php foreach ($buku as $b) { ?> 
        <div class="card mb-2" style="width: 550px; ">
          <div class="row no-gutters">
            <div class="col-md-4 p-4">
              <img src="<?php echo base_url(); ?>asset/upload/<?= $b->gambar; ?>" width="180" height="170">
            </div>
            <div class="col-md-8 ">
              <div class="card-body ml-5 pt-2">
                <p class="card-header">Detail Buku</p>
                <h5 class="card-title"></h5>
                <p class="card-text">Judul : <?= $b->judul_buku; ?></p>
                <p class="card-text">penerbit : <?= $b->penerbit; ?></p>
                <p class="card-text">Pengarang  : <?= $b->pengarang; ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php } ?> 
      <button type="button" class="btn btn-success" >
          <a class="text-white" href="<?= base_url('user/buku'); ?> ">Kembali <i class="fas fa-backward"></i></a></button>
      </div>
    </div>

