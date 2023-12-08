<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url(); ?>../../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?= $title; ?></title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>../../logopuskesmas.png" alt="" style="width: 20px;" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/fonts/tabler-icons.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/apex-charts/apex-charts.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/swiper/swiper.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/libs/select2/css/select2.min.css">
  <!-- Page CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>../../assets/vendor/css/pages/cards-advance.css" />

  <!-- Helpers -->
  <script src="<?= base_url(); ?>../../assets/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="<?= base_url(); ?>../../assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?= base_url(); ?>../../assets/js/config.js"></script>

  <script src="<?= base_url(); ?>../../assets/js/jquery-3.4.1.min.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?= $this->include('templates/sidebar'); ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?= $this->include('templates/navbar') ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Content -->
            <?= $this->renderSection('page-content'); ?>
            <!-- / Content -->
          </div>

          <!-- Footer -->
          <?= $this->include('templates/footer') ?>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->

  <script src="<?= base_url(); ?>../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/popper/popper.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/js/bootstrap.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/hammer/hammer.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/i18n/i18n.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->
  <!-- Select2 -->
  <script src="<?= base_url(); ?>../../assets/vendor/libs/select2/js/select2.full.min.js"></script>

  <!-- Vendors JS -->
  <script src="<?= base_url(); ?>../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/swiper/swiper.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

  <script src="<?= base_url(); ?>../../assets/vendor/libs/autosize/autosize.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/cleavejs/cleave.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
  <script src="<?= base_url(); ?>../../assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>

  <!-- Main JS -->
  <script src="<?= base_url(); ?>../../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="<?= base_url(); ?>../../assets/js/dashboards-analytics.js"></script>
  <script src="<?= base_url(); ?>../../assets/js/forms-extras.js"></script>

  <script>
    $(document).ready(function() {
      $('#datatabelpasien').DataTable({
        "lengthMenu": [
          [25, 50, 75, 100, -1],
          [25, 50, 75, 100, "All"]
        ]
      });
    });

    $(document).ready(function() {
      $('#datatabelpoli').DataTable({
        "lengthMenu": [
          [25, 50, 75, 100, -1],
          [25, 50, 75, 100, "All"]
        ]
      });
    });

    $(document).ready(function() {
      $('#datatabelkaryawan').DataTable({
        "lengthMenu": [
          [25, 50, 75, 100, -1],
          [25, 50, 75, 100, "All"]
        ]
      });
    });

    $(document).ready(function() {
      $('#datatabelpengguna').DataTable({
        "lengthMenu": [
          [25, 50, 75, 100, -1],
          [25, 50, 75, 100, "All"]
        ]
      });
    });

    $(document).ready(function() {
      $('#datatabelobat').DataTable({
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
        ]
      });
    });

    $(document).ready(function() {
      $('#datatabellaporan').DataTable({
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
        ]
      });
    });

    $(document).ready(function() {
      $('#datatabeldetaillaporan').DataTable({
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
        ]
      });
    });

    function confirmToDelete(el) {
      $("#delete-button").attr("href", el.dataset.href);
      $("#confirm-dialog").modal('show');
    }

    $(document).ready(function() {
      $('#jenkelold').select2();
      $('#jenkel').select2();
    });
  </script>
</body>

</html>