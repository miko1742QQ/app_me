<aside id="layout-menu" class="layout-menu menu-vertical menu bg-success">
  <div class="app-brand demo">
    <a href="../index" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="../../Logo_Padang.png" alt="" style="width: 20px;">
      </span>
      <span class="app-brand-text demo menu-text fw-bold text-white">SISPUS</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto text-white">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <?php if (in_groups('Administrator') || in_groups('Pimpinan')) : ?>
      <!-- Dashboards -->
      <li class="menu-item ">
        <a href="dashboard" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
      <!-- Master Data menu start -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle text-white">
          <i class="menu-icon tf-icons ti ti-server"></i>
          <div data-i18n="Master Data">Master Data</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="daftar_pasien" class="menu-link text-white">
              <div data-i18n="Pasien">Pasien</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="daftar_poli" class="menu-link text-white">
              <div data-i18n="Poli">Poli</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="daftar_obat" class="menu-link text-white">
              <div data-i18n="Obat">Obat</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="daftar_karyawan" class="menu-link text-white">
              <div data-i18n="Karyawan">Karyawan</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="daftar_pengguna" class="menu-link text-white">
              <div data-i18n="Pengguna">Pengguna</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="nomor_antrian" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-ticket"></i>
          <div data-i18n="No. Antrian">No. Antrian</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="hapus_nomorantrian" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-ticket"></i>
          <div data-i18n="No. Antrian Poli">No. Antrian Poli</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="daftar_transaksi" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-receipt"></i>
          <div data-i18n="Transaksi">Transaksi</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="laporan_transaksi" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-printer"></i>
          <div data-i18n="Laporan Transaksi">Laporan Transaksi</div>
        </a>
      </li>
      <!-- Dashboards -->
    <?php endif ?>

    <?php if (in_groups('Petugas')) : ?>
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="dashboard" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="nomor_antrian" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-ticket"></i>
          <div data-i18n="No. Antrian">No. Antrian</div>
        </a>
      </li>
      <!-- Dashboards -->
    <?php endif ?>

    <?php if (in_groups('Karyawan')) : ?>
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="dashboard" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="hapus_nomorantrian" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-ticket"></i>
          <div data-i18n="No. Antrian Poli">No. Antrian Poli</div>
        </a>
      </li>
      <!-- Dashboards -->
    <?php endif ?>

    <?php if (in_groups('Kasir')) : ?>
      <!-- Dashboards -->
      <li class="menu-item">
        <a href="dashboard" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="daftar_transaksi" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-receipt"></i>
          <div data-i18n="Transaksi">Transaksi</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="laporan_transaksi" class="menu-link text-white">
          <i class="menu-icon tf-icons ti ti-printer"></i>
          <div data-i18n="Laporan Transaksi">Laporan Transaksi</div>
        </a>
      </li>
      <!-- Dashboards -->
    <?php endif ?>
  </ul>
</aside>