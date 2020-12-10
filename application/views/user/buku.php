<div class="container-fluid">
<?= $this->session->flashdata('message'); ?> 
<a href="<?php echo base_url().'user/tambah_peminjaman'; ?>" class="btn
btn-primary btn-xs"><i class="fas fa-plus"></i> Transaksi
Baru</a>
<hr>
    <div style="padding: 25px;"> 
        <div class="x_panel"> 
            <div class="x_content"> 
                <!-- Tampilkan semua produk --> 
                <div class="row"> 
                    <!-- looping products --> 
                    <?php foreach ($buku as $b) { ?> 
                        <div class="col-md-2 col-md-3"> 
                            <div class="thumbnail" style="height: 370px;"> 
                                <img src="<?php echo base_url(); ?>asset/upload/<?= $b->gambar; ?>" style="max-width:100%; max-height: 100%; height: 200px; width: 180px"> 
                                   
                                       <p><a href="<?php echo base_url(). 'user/detail_buku/' .$b->id_buku; ?>"><?= $b->judul_buku; ?></a></p>
                                       
                                        </div>   
                                    </div> <?php } ?> 
                                <!-- end looping --> 
                            </div> 
                        </div> 
                    </div> 
                </div>
            </div>