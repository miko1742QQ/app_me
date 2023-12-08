<?= $this->extend('./templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php if (session()->getFlashdata('error')) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Maaf,</strong> <?= session()->getFlashdata('error'); ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil,</strong> <?= session()->getFlashdata('success'); ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>


<div class="card shadow">
    <div class="row card-header p-2 m-0 align-items-center">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="py-2 mt-2">Daftar Nomor Antrian</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">

        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive margin-tb">
            <table class="table table-hover display nowrap w-100" id="" cellspacing="0">
                <thead>
                    <tr class="first even" style="text-shadow: none; cursor: pointer;">
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NO</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">TANGGAL</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">KODE POLI</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NAMA POLI</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NOMOR ANTRIAN</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($antrian as $value) : ?>
                        <tr style="vertical-align: middle; text-align: center; text-shadow: none;">
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $nomor++; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= date('d/m/Y', strtotime($value["tanggal"])); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $value["kode_poli"]; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $value["nama_poli"]; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $value["nomor_antrian"]; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;">
                                <a href="#" data-href="<?= base_url('delete_antrian/' . $value['id']) ?>" onclick="confirmToDelete(this)" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                    <span class='icon'><i class='fas fa-trash'></i></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <div id="confirm-dialog" class="modal fade" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body d-flex flex-column">
                            <span><b>Apa kamu yakin ingin menghapus data ini?</b></span>
                            <span>Data akan hilang untuk selamanya dan tidak bisa dikembalikan</span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <a href="#" role="button" id="delete-button" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan dialog konfirmasi penghapusan
    function confirmToDelete(element) {
        const deleteButton = document.getElementById('delete-button');
        deleteButton.setAttribute('href', element.getAttribute('data-href'));

        $('#confirm-dialog').modal('show');
    }

    $(document).ready(function() {
        $('#jenispoli').select2();
    });
</script>
<?= $this->endSection(); ?>