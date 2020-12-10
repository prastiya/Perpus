 <div class="container-fluid">

          <!-- Page Heading -->

<?php echo $this->session->flashdata('message');  ?>

                  <a href="<?php echo base_url().'admin/tambah_buku'; ?>"  class="btn btn-primary btn-icon-split"> <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text" >Tambah Data Buku</span></a>
				
            <br>
            <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-info">Data Buku</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
				<th>No</th>
				<th>Gambar</th>
				<th>Judul Buku</th>
				<th>pengarang</th>
				<th>penerbit</th>
				<th>Tahun Terbit</th>
				<th>ISBN</th>
				<th>Lokasi</th>
				<th>Status</th>
				<th>Pilihan</th>
			</tr>
                  </thead>
                   
                  
                  <tbody>
                     <?php
			$no = 1;
			foreach($buku as $b){
			?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><img src="<?php echo base_url().'/asset/upload/'.$b->gambar; ?>" width="80" height="80" alt="gambar tidak ada " ></td>
				<td><?php echo $b->judul_buku ?></td>
				<td><?php echo $b->pengarang ?></td>
				<td><?php echo $b->penerbit ?></td>
				<td><?php echo $b->thn_terbit ?></td>
				<td><?php echo $b->isbn ?></td>
				<td><?php echo $b->lokasi ?></td>
				<td>
					<?php 
					if($b->status_buku == "1"){
						echo "Tersedia";
					}else if($b->status_buku == "0"){
						echo "Sedang dipinjam";
					}
					?>
				</td>
				<td nowrap="nowrap" style="text-align: center;">
					 <a href="<?php echo base_url(). 'admin/edit_buku/' .$b->id_buku; ?>" class="btn btn-info btn-circle btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
					
					 <a href="<?php echo base_url(). 'admin/hapus_buku/' .$b->id_buku; ?>" class="btn btn-danger btn-circle btn-sm">
                    <i class="fas fa-trash"></i>
                  </a>
				
					
				</td>
			</tr>
<?php } ?> </tbody>
                 
                </table>
              </div>
            </div>
          </div>

        </div>


<!-- Button trigger modal -->
